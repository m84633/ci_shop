<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
    private $user_data;
    public function __construct()
    {
            parent::__construct();
            $this->load->model('order');
            $this->user_data = $this->session->userdata();
    }

    public function index(){
        $this->is_login();

        $head_data = [
            'title' => '訂單',
        ];
        $view_data = [];
        $where_data = [
            'user_id'   => $this->user_data['user_id']
        ];
        $view_data['orders'] = $this->order->select_index($where_data);
        $foot_data['scripts'][] = base_url('assets/js/order_index.js');
        $foot_data['scripts'][] = "https://cdn.jsdelivr.net/npm/@tensorflow/tfjs/dist/tf.min.js";


        $this->render('order/index',$head_data,$view_data,$foot_data);
    }

    public function add(){
        $this->is_login();

        $this->load->library('uuid');
        $this->load->library('form_validation');
        $this->load->library('ecpay');
        $this->form_validation->set_rules('name','姓名','trim|required')
                            ->set_rules('email','Email','trim|valid_email');
        if($this->form_validation->run()){
            if($this->input->post('email')){
                $email = $this->input->post('email');
            }else{
                $email = $this->user_data['email'];
            }
            $cart = [
                'items'  => $this->user_data['cart'],
                'total'  => $this->user_data['total'],
                'sum'    => $this->user_data['sum']
            ];
            $uuid = str_replace("-","",substr($this->uuid->v4(),0,20));
            $insert_data = [
                'name'      => $this->input->post('name'),
                'email'     => $email,
                'cart'      => serialize($cart),
                'user_id'   => $this->user_data['user_id'],
                'uuid'      => $uuid
            ];
            $result = $this->order->insert($insert_data);

            //串接綠界
            try{
                    $obj = $this->ecpay->load();
   
                    //服務參數
                    $obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";   //服務位置
                    $obj->HashKey     = '5294y06JbISpM5x9' ;                                           //測試用Hashkey，請自行帶入ECPay提供的HashKey
                    $obj->HashIV      = 'v77hoKGq4kWxNNIS' ;                                           //測試用HashIV，請自行帶入ECPay提供的HashIV
                    $obj->MerchantID  = '2000132';                                                     //測試用MerchantID，請自行帶入ECPay提供的MerchantID
                    $obj->EncryptType = '1';                                                           //CheckMacValue加密類型，請固定填入1，使用SHA256加密


                    //基本參數(請依系統規劃自行調整)
                    $MerchantTradeNo = $uuid ;
                    $obj->Send['ReturnURL']         = "https://e4437d10071f.ngrok.io/ci_shop/orders/callback" ;    //付款完成通知回傳的網址
                    $obj->Send['ClientBackURL'] = "https://e4437d10071f.ngrok.io/ci_shop/orders/redirect" ;
                    $obj->Send['MerchantTradeNo']   = $MerchantTradeNo;                          //訂單編號
                    $obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                       //交易時間
                    $obj->Send['TotalAmount']       = $_SESSION['sum'];                                      //交易金額
                    $obj->Send['TradeDesc']         = "Ez網路書城" ;                          //交易描述
                    $obj->Send['ChoosePayment']     = ECPay_PaymentMethod::Credit ;              //付款方式:Credit
                    $obj->Send['IgnorePayment']     = ECPay_PaymentMethod::GooglePay ;           //不使用付款方式:GooglePay

                    //訂單的商品資料
                    foreach($_SESSION['cart'] as $item){
                        array_push($obj->Send['Items'], array('Name' => $item['item']->name, 'Price' => (int)$item['item']->price,
                                   'Currency' => "元", 'Quantity' => (int) $item['count'], 'URL' => "dedwed"));
                    }


                    //Credit信用卡分期付款延伸參數(可依系統需求選擇是否代入)
                    //以下參數不可以跟信用卡定期定額參數一起設定
                    $obj->SendExtend['CreditInstallment'] = '' ;    //分期期數，預設0(不分期)，信用卡分期可用參數為:3,6,12,18,24
                    $obj->SendExtend['InstallmentAmount'] = 0 ;    //使用刷卡分期的付款金額，預設0(不分期)
                    $obj->SendExtend['Redeem'] = false ;           //是否使用紅利折抵，預設false
                    $obj->SendExtend['UnionPay'] = false;          //是否為聯營卡，預設false;

                    //Credit信用卡定期定額付款延伸參數(可依系統需求選擇是否代入)
                    //以下參數不可以跟信用卡分期付款參數一起設定
                    // $obj->SendExtend['PeriodAmount'] = '' ;    //每次授權金額，預設空字串
                    // $obj->SendExtend['PeriodType']   = '' ;    //週期種類，預設空字串
                    // $obj->SendExtend['Frequency']    = '' ;    //執行頻率，預設空字串
                    // $obj->SendExtend['ExecTimes']    = '' ;    //執行次數，預設空字串
                    
                    # 電子發票參數
                    /*
                    $obj->Send['InvoiceMark'] = ECPay_InvoiceState::Yes;
                    $obj->SendExtend['RelateNumber'] = "Test".time();
                    $obj->SendExtend['CustomerEmail'] = 'test@ecpay.com.tw';
                    $obj->SendExtend['CustomerPhone'] = '0911222333';
                    $obj->SendExtend['TaxType'] = ECPay_TaxType::Dutiable;
                    $obj->SendExtend['CustomerAddr'] = '台北市南港區三重路19-2號5樓D棟';
                    $obj->SendExtend['InvoiceItems'] = array();
                    // 將商品加入電子發票商品列表陣列
                    foreach ($obj->Send['Items'] as $info)
                    {
                        array_push($obj->SendExtend['InvoiceItems'],array('Name' => $info['Name'],'Count' =>
                            $info['Quantity'],'Word' => '個','Price' => $info['Price'],'TaxType' => ECPay_TaxType::Dutiable));
                    }
                    $obj->SendExtend['InvoiceRemark'] = '測試發票備註';
                    $obj->SendExtend['DelayDay'] = '0';
                    $obj->SendExtend['InvType'] = ECPay_InvType::General;
                    */
                    unset($_SESSION['cart']);
                    unset($_SESSION['total']);
                    unset($_SESSION['sum']);                   

                    //產生訂單(auto submit至ECPay)
                    $obj->CheckOut();
            }catch(Exception $e){
                echo $e->getMessage();
            }

        }else{
            set_userdata('error','建立訂單失敗!');
            return redirect('products/checkout');            
        }
    }

    public function callback(){
        $this->load->library('ecpay');
        $ecpay = $this->ecpay->load();


        // $strr = print_r($_POST,true);
        // file_put_contents(APPPATH."/readme.txt",$strr,FILE_APPEND);

        $callback = $_POST;
        $ECPay_MerchantID = "2000132";
        $ECPay_HashKey = "5294y06JbISpM5x9";
        $ECPay_HashIV = "v77hoKGq4kWxNNIS";
        //進行驗證
        $check = ECPay_CheckMacValue::generate( $callback, $ECPay_HashKey, $ECPay_HashIV, 1);
        if($_POST['RtnCode'] == '1' && $check == $_POST['CheckMacValue']){
            $where_data = [
                'uuid'  => $_POST['MerchantTradeNo']
            ];
            $update_data = [
                'payment'   => '1'
            ];
            $result = $this->order->update($where_data,$update_data);
        }
        // $where_data = [
        //     'uuid'  =>  'a8906105880f49b1b'
        // ];
        // $update_data = [
        //     'payment' => 1
        // ];
        // $this->order->update($where_data,$update_data);

    }

    public function redirect(){
        $this->is_login();

        // $this->order->update($where_data,$update_data);
        $this->session->set_flashdata('success','訂單建立成功,感謝您的購買!!');
        return redirect(base_url('orders'));
    }

    public function detail(){
        $this->is_login();  
        $id = $this->input->post('id');
        $where_data = [
            'id'    => $id
        ];
        $cart = $this->order->detail($where_data);


        $response = [
            'id'        => $id,
            'token'     => $this->security->get_csrf_hash(),
            'detail'    => unserialize($cart['cart'])

        ];
        echo json_encode($response);
    }

    private function is_login(){
        if(!isset($_SESSION['login']) && !$_SESSION['login']){
            return redirect(base_url('users/login'));
        }       
    }

    private function render($page,$head,$view,$foot=[]){
        $head['user'] = $this->user_data;

        $this->load->view('layouts/header',$head);
        $this->load->view($page,$view);
        $this->load->view('layouts/footer',$foot);
    }
}
