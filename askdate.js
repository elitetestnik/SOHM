function ask_date(siteBase, lang, contractId) {
    
    var d = new Date();
    var date = d.getDate();
    var month = d.getMonth() + 1; //Months are zero based
    var year = d.getFullYear();
    var format = date + "/" + month + "/" + year;

    var target = siteBase+"/modules/invoice.php?lang="+lang+"&id="+contractId;      
    var date = prompt('Please enter terms date', format);
    
    target += (target.indexOf('?') === -1?'?':'&');
    target += 'date='+date;     
    if(date!==null){
            document.location.replace("http://"+target);
    }
}
                            
