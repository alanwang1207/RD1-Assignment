$(function () {
    $.ajax({
      type: "GET",
      url: "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-001?Authorization=CWB-20260A47-5D47-474D-AABA-BBC6BC84F310&format=JSON",
      dataType: "json",
      error: function (e) {
        console.log('oh no');
      },
      success: function (e) {
        var xml = e;
        console.log(typeof($(xml)));
       
        
      }
      
    });
    
  });