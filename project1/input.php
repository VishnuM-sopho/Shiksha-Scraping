<!DOCTYPE html>

<html>

    <head>

        <!-- http://getbootstrap.com/ -->
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>

        <link href="/css/styles.css" rel="stylesheet"/>

        
        <!-- https://jquery.com/ -->
        <script src="/js/jquery-1.11.3.min.js"></script>

       
       <script>
     
function post(){
        $web1 =$("#web").val();
   // $("#res").hide();
           
    $.ajax({
        url : 'vf.php',
        type :"POST",
        data : {'web':$web1},
        beforeSend :function(){
            //alert(1);
              $('.enter').hide();
            $('.container').hide();
            $('.load1').show();
            $("#res").hide();
           $('.load1').css({'background-image' : 'url("https://vishnum21998-vishnum1998.cs50.io/loader.gif")',
      'background-repeat': 'no-repeat','top' : '50%','left' : '50%'});
          
        },
        success: function(data){
            $('.container').show();
            $("#res").html(data);
            $("#res").show();
            
            $('#web').hide();
            $('#top').hide();
            $('#but').hide();
           // $('.middle').hide();
            //.delay(2000).hide(4);
              $('.load1').css('background', 'rgba(255,255,255)');
          //alert(2);
          $('.load1').hide();
          $('.enter').show();
           
        
        }
    });
    
};
        
    </script>
    
         <body>

        <div class="container">

            <div id="top">
                
               
                    <ul class="nav nav-pills">
                        Input website
                    </ul>
            </div>

            <div id="middle">

    </head>
    <form>
            <input id="web" placeholder="Website" type="text">
        <input id="but" type="button" value="Submit" onclick="post();">
    </form>
   </div>
          

        </div>
        
        
        <div class="load1">
            <div id ="middle">
             <p> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> </p>
            </div>
            
        </div>
          <div class="enter"> <p>
                <a href = "input.php">Enter website again</a>
    
            </p></div>
        <p><br><br><br><br><br></p>
        
        <style>table {
    width:100%;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;
}
table#t01 tr:nth-child(even) {
    background-color: #eee;
}
table#t01 tr:nth-child(odd) {
   background-color:#fff;
}
table#t01 th {
    background-color: black;
    color: white;
}

</style>
        
         
         <div id="res">
             
        
      
  
    </div>
    
    
       
   
    </body>

</html>
