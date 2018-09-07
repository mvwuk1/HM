<?php session_start();?>
<!DOCTYPE html> 
<html>
	<head>
    <?php
        if (isset($_SESSION['LoginStatus']) == false) {
            header("location:hm.php");            
        }   
        include_once "inc/lib1.php"; // jQuery and Bootstrap
    ?>
        <script>
            var selQVal = 0;
            var selQJSON = "";
            var strParProj = "OP10565";
            var strParQid = "";
            var strJSONFilename =  "";
            var incResp = 1;
            var dataArr = {"Rows":[]};
            var dataArrMob = {"Rows":[]};
            var iRows = 0;
            var iCols = 0;
            var tot = 0;
            var strImgURL = '';
            var strLocalImgURL = '';
            var parImageScaleBy = '';
            var parImageSize = '';
            var parHighlightSize ='';            		  
            var parImageHeight = '';
            var parImageWidth = '';
            var respCount = 0;
            var dataCount = 0;
            var pcCount = 0;
            var mobCount = 0;
            var intBase = 0;
            var debug = true;
            var intMinClick = 0;
            var blnSavable = false;

            $(document).ready(function(){
                $(".cControlsOuter").hide();
                $("#selBase").val(3);

                $("#cmdSelect").on("click", function(e) {
                    e.preventDefault;
                    fncCleanUp();                    
                    selQVal = $("#selQuest").val();
                    strParQid = $("#selQuest option[value='" + selQVal + "']").text();
                    selQJSON = $("#selQuest option[value='" + selQVal + "']").attr("data-json");
                    strJSONFilename =  "data/" + selQJSON;
                    fncDebug("1 Call Process");
                    fncProcessJson();

                });
                $("#cmdSelect2").on("click", function(e) {
                    e.preventDefault;
                    fncDebug("s1");
                    show = $("#selShow").val();
                    Base = $("#selBase").val();
                    Color = $("#selColor").val();
                    fncDebug("s2");
                    $('#CanvasOuter1').html('');
                    fncSetShade(show,Base,Color);
                    fncCreateImage(show);
                });
                $("#selShow").on("change",function() {
                    $("#selBase").val($(this).val());
                });
                $('.cHM_Image').on('load', function() {
                    fncDebug(5);
                    fncFormatGrid();
                });
                $('.cHM_Image').on('error', function() {
                    blnSavable = false;
                    strLocalImgURL = strImgURL;
                    $(".cHM_Image").attr("src",strLocalImgURL);
                });
                $("#btnSave1").click(function() { 
                    var position = $('.cHM_Image').position();
                    $('.cGridOuter').css('position','absolute');
                    $('.cGridOuter').css('top',position.top);

                    html2canvas(document.querySelector("#ImgHolder")).then(canvas => {
                        $('#CanvasOuter1').append(canvas)
                    });    
                });                
            });


        </script>
	</head>
	<body>
        <div class="container">
            <?php
            
            include_once "inc/header.php"; 
            ?>
            <div class="cLogoutCmd">
                <?php echo $_SESSION['LoginStatus']; ?>
                <form action="logout.php">
                    <button>Logout</button>    
                </form>
            </div>
            <div class="cMain">
                <div class="cSetQuest">
                    <form method="post" action="logout.php" id="SelectQuestFrm">
                        <select class="cDropdown-menu" id="selQuest">
                            <option value="1" data-json="Q16_Aqua_DD.json">Q16 Aqua DD</a></option>
                            <option value="2" data-json="Q16_Aqua_NONDD.json">Q16 Aqua NON DD</a></option>
                            <option value="3" data-json="Q16DebDD.json">Q16 Deb DD</a></option>
                            <option value="4" data-json="Q16_Deb_nonDD.json">Q16 Deb NON DD</a></option>
                            <option value="5" data-json="Q16_DP_DD.json">Q16 DP DD</a></option>
                            <option value="6" data-json="Q16_DP_NONDD.json">Q16 DP NON DD</a></option>
                            <option value="7" data-json="Q17_Aqua_DD.json">Q17 Aqua DD</a></option>
                            <option value="8" data-json="Q17_Aqua_NONDD.json">Q17 Aqua NON DD</a></option>
                            <option value="9" data-json="Q17_Deb_DD.json">Q17 Deb DD</a></option>
                            <option value="10" data-json="Q17_Deb_nonDD.json">Q17 Deb NON DD</a></option>
                            <option value="11" data-json="Q17_DP_DD.json">Q17 DP DD</a></option>
                            <option value="12" data-json="Q17_DP_NONDD.json">Q17 DP NON DD</a></option>
                            <option value="13" data-json="Q18_Aqua_DD.json">Q18 Aqua DD</a></option>
                            <option value="14" data-json="Q18_Aqua_NONDD.json">Q18 Aqua NON DD</a></option>
                            <option value="15" data-json="Q18_Deb_DD.json">Q18 Deb DD</a></option>
                            <option value="16" data-json="Q18_Deb_nonDD.json">Q18 Deb NON DD</a></option>
                            <option value="17" data-json="Q18_DP_DD.json">Q18 DP DD</a></option>
                            <option value="18" data-json="Q18_DP_NONDD.json">Q18 DP NON DD</a></option>                    
                        </select>

                        <button type="button" class="btn btn-primary" name="cmdSelect" id="cmdSelect" >Set</button> 
                    </form>
                </div>
                <div id="debugStage"></div>
                <div class="cOuter">
                    <div class="cControlsOuter">
                        <select class="cDropdown-menu" id="selBase">
                            <option value="1">Base: All Respondents</option>
                            <option value="2">Base: Respondents with Data</option>
                            <option value="3">Base: Non Mobile Respondents</option>
                            <option value="4">Base: Mobile Respondents</option>
                        </select>
                        <select class="cDropdown-menu" id="selShow">
                            <option value="3">Show: Non Mobile Respondents</option>
                            <option value="4">Show: Mobile Respondents</option>
                            <!-- <option value="1">Show: All Respondents</option> -->
                        </select>
                        <select class="cDropdown-menu" id="selColor">
                            <option value="1">Color: Green</option>
                            <option value="2">Color: Red</option>
                        </select>
                        <label for="minClick">Min Click</label>
                        <input class="Pin" size="4" maxlength="4" type="number" class="form-control" id="minClick" name="minClick" value="1">
                        <button type="button" class="btn btn-primary" name="cmdSelect" id="cmdSelect2" >Show Data</button> 
                    </div>
                    <div class="cInfo">

                    </div>
                    <div id="ImgHolder">
                        <img class="cHM_Image" src="" />
                        <div class="cGridOuter" id="gridOuter_non"></div>
                        <div class="cGridOuter" id="gridOuter_mob"></div>                
                    </div>
                </div>
            </div>
            <div id="image">            				
                <h4>Right click on the image to save</h4>
                <input type="button" id="btnSave1" value="Create PNG"/>
                <div class="cLine"></div>
                <div id="CanvasOuter1">
                    <h3>ImageOut</h3>
                </div> 

            </div>
        

    </body>
</html>