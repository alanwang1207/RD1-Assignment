fetch('https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-20260A47-5D47-474D-AABA-BBC6BC84F310&format=JSON&elementName=Wx&sort=time')
.then(res => {
    return res.json();
}).then(result => {
    let city = record.location[14].locationName
    // let temp = result.cwbopendata.location[14].weatherElement[3].elementValue.value;
    console.log(`${city}的氣溫`); // 得到 高雄市的氣溫為 29.30 度 C
});