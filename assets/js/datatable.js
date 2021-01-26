	$(document).ready( function () {
      // if($("a.delete").length){
      //   $("a.delete").on("click",function(e){
      //     if(confirm("是否要刪除?")){
      //       $("#delete")
      //     }
      //     return false
      //   })
      // }
	    $('#datatable').DataTable({
	      "paging": true,
	      "lengthChange": false,
      "pageLength": 5,
	      "searching": true,
	      "ordering": true,
	      "info": false,
	      "autoWidth": false,
	      "responsive": true,
      "language": {
        "emptyTable":"無相關資料",
        "search":"搜尋:",
        "paginate": {
        "first":"第一頁",
        "last":"最後一頁",
        "next":"下一頁",
        "previous":"上一頁",
        },
        "zeroRecords":"無相關紀錄",
      }
	    });
	} );
