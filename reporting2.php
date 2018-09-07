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
            var debug = false;
            var intMinClick = 0;
            var intOffSet = 0;
            var blnSavable = false;

            $(document).ready(function(){
                $("#selBase").val(3);
                $(".cControlsOuter").hide();
                fncColorPicker();
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
                    Color = $("#color").val();
                    fncDebug("s2");
                    $("#ImgHolder").show();
                    $("#Imgage").hide();
                    $('#CanvasOuter1').html('');
                    fncSetShadeV2(show,Base,Color);
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
                        $('#CanvasOuter1').append("<span class=\"cSaveText\">Right Click to save image.</span>");
                        $('#CanvasOuter1').append(canvas)
                        $("#ImgHolder").hide();
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
                            <option value="1" data-json="Q16_Aqua_DD.json">Q16 Aqua DD</option>
                            <option value="2" data-json="Q16_Aqua_NONDD.json">Q16 Aqua NON DD</option>
                            <option value="3" data-json="Q16DebDD.json">Q16 Deb DD</option>
                            <option value="4" data-json="Q16_Deb_nonDD.json">Q16 Deb NON DD</option>
                            <option value="5" data-json="Q16_DP_DD.json">Q16 DP DD</option>
                            <option value="6" data-json="Q16_DP_NONDD.json">Q16 DP NON DD</option>
                            <option value="7" data-json="Q17_Aqua_DD.json">Q17 Aqua DD</option>
                            <option value="8" data-json="Q17_Aqua_NONDD.json">Q17 Aqua NON DD</option>
                            <option value="9" data-json="Q17_Deb_DD.json">Q17 Deb DD</option>
                            <option value="10" data-json="Q17_Deb_nonDD.json">Q17 Deb NON DD</option>
                            <option value="11" data-json="Q17_DP_DD.json">Q17 DP DD</option>
                            <option value="12" data-json="Q17_DP_NONDD.json">Q17 DP NON DD</option>
                            <option value="13" data-json="Q18_Aqua_DD.json">Q18 Aqua DD</option>
                            <option value="14" data-json="Q18_Aqua_NONDD.json">Q18 Aqua NON DD</option>
                            <option value="15" data-json="Q18_Deb_DD.json">Q18 Deb DD</option>
                            <option value="16" data-json="Q18_Deb_NONDD.json">Q18 Deb NON DD</option>
                            <option value="17" data-json="Q18_DP_DD.json">Q18 DP DD</option>
                            <option value="18" data-json="Q18_DP_NONDD.json">Q18 DP NON DD</option>
                            <option value="19" data-json="Q19_Aqua_DD.json">Q19 Aqua DD</option>
                            <option value="20" data-json="Q19_Aqua_NONDD.json">Q19 Aqua NON DD</option>
                            <option value="21" data-json="Q19_Deb_DD.json">Q19 Deb DD</option>
                            <option value="22" data-json="Q19_Deb_NONDD.json">Q19 Deb NON DD</option>
                            <option value="23" data-json="Q19_DP_DD.json">Q19 DP DD</option>
                            <option value="24" data-json="Q19_DP_NONDD.json">Q19 DP NON DD</option>                             
                        </select>

                        <button type="button" class="btn btn-primary" name="cmdSelect" id="cmdSelect" >Set</button> 
                    </form>
                </div>
                <div id="debugStage"></div>
                <div class="cOuter">
                    <div class="cControlsOuter">
                        <select class="cDropdown-menu" id="selBase" title="Select the base used for calculating the highlight percentage for cells.">
                            <option value="1">Base: All Respondents</option>
                            <option value="2">Base: Respondents with Data</option>
                            <option value="3">Base: Non Mobile Respondents</option>
                            <option value="4">Base: Mobile Respondents</option>
                        </select>
                        <select class="cDropdown-menu" id="selShow" title="Select which respondents to show based on the device the used to answer the questionnaire.">
                            <option value="3">Show: Non Mobile Respondents</option>
                            <option value="4">Show: Mobile Respondents</option>
                            <!-- <option value="1">Show: All Respondents</option> -->
                        </select>
                        <label for="color" title="Select the shading colur. Click on the button to show a colour picker.">Color:</label>
                        <input type="text" id="color" name="color" size="8" value="#123456"  title="Select the shading colur. Click on the button to show a colour picker."/>
                        <button type="button" class=".btn-xs btn-primary" data-toggle="modal" data-target="#ColPickWrapper" title="Select the shading colur. Click on the button to show a colour picker.">...</button>
                        <label for="shadeOffset" title="Enter the shading offet e.g. if the cell value is 10% of the base and the offset is 50, the cell with be 60% shaded.">Shade Offset:</label>
                        <input type="text" id="shadeOffset" name="shadeOffset" size="2" value="50"  title="Enter the shading offet e.g. if the cell value is 10% of the base and the offset is 50, the cell with be 60% shaded."/>
                        <div id="ColPickWrapper" class="modal fade" role="dialog">
                            <div class="modal-dialog  modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Select Colour</h4>
                                    </div>
                                    <div class="modal-body">                                
                                        <div id="picker"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>                                    
                        </div>
                        <label for="minClick" title="The minimun number of responses before a cell  is shown as shaded.">Min Click</label>
                        <input size="4" maxlength="4" type="number" id="minClick" name="minClick" value="1" title="The minimun number of responses before a cell  is shown as shaded.">
                        <button type="button" class="btn btn-primary" name="cmdSelect" id="cmdSelect2"  title="Show the shading on the image based on the responses.">Show Data</button> 
                        <input type="button" class="btn btn-primary" name="btnSave1" id="btnSave1" value="Convert to Image"   title="Show image and shading so it can be saved by right clicking on the imnage."/>                        
                    </div>
                    <div class="cInfo">

                    </div>
                    <div id="ImgHolder">
                        <img class="cHM_Image" src="" />
                        <div class="cGridOuter" id="gridOuter_non"></div>
                        <div class="cGridOuter" id="gridOuter_mob"></div>                
                    </div>
                    <div id="image">            				
                        <div id="CanvasOuter1"></div>
                    </div>                    
                </div>
            </div>

        </div>

    </body>
</html>