/*in mẫu hồ sơ*/
function inmaunhanhoso(){
    $("#btinmaunhanhoso").css("display", "none");
    $("#xuatwordmaunhanhoso").css("display", "none");
    window.print();
    $("#btinmaunhanhoso").css("display", "inline");
    $("#xuatwordmaunhanhoso").css("display", "inline");
}
function xuatword(tenfile){
    Export2Doc($("#maunhanhoso").html(),tenfile);
}
//-----------in bill cho hĂ³a Ä‘Æ¡n
function inmau(html){
    var mywindow = window.open('', 'In Mẫu', '');
    mywindow.document.write(html);
    mywindow.print();
    mywindow.close();
}      
  
function Export2Doc(html_element, filename = ''){
    var preHtml = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40"><head><title>Microsoft Office HTML Example</title><!--[if gte mso 9]><xml><w:WordDocument><w:View>Print</w:View><w:Zoom>100</w:Zoom><w:DoNotOptimizeForBrowser/></w:WordDocument></xml><![endif]--><body>';

    var postHtml = "</body></html>";
    var html = preHtml+html_element+postHtml;

    var blob = new Blob(['\ufeff', html], {
        type: 'application/msword'
    });
    
    // Specify link url
    var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
    
    // Specify file name
    filename = filename?filename+'.doc':'document.doc';
    
    // Create download link element
    var downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob ){
        navigator.msSaveOrOpenBlob(blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = url;
        
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
    
    document.body.removeChild(downloadLink);
}
