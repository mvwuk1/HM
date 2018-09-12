<?php session_start();?>
<!DOCTYPE html> 
<html>
	<head>
    <?php
        if (isset($_SESSION['LoginStatus']) == false) {
            session_destroy();
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
                    fncProcessJson();
                });
                $("#cmdSelect2").on("click", function(e) {
                    e.preventDefault;
                    Base = $("#selBase").val();
                    Color = $("#selColor").val();
                    fncSetShade(Base,Color);
                });
                $('.cHM_Image').on('load', function() {
                    fncDebug(5);
                    fncFormatGrid();
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
        <div class="cSetQuest">
            <form method="post" action="logout.php" id="SelectQuestFrm">
                <select class="cDropdown-menu" id="selQuest">
                    <option value="1" data-json="Q16_Aqua_DD.json">Q16 Aqua DD</a></option>
                    <option value="2" data-json="Q16_Aqua_NONDD.json">Q16 Aqua NON DD</a></option>
                    <option value="3" data-json="Q16DebDD.json">Q16 Deb DD</a></option>
                    <option value="4" data-json="Q16_Deb_nonDD.json">Q16 Deb NON DD</a></option>
                    <option value="5" data-json="Q16_DP_DD.json">Q16 DP DD</a></option>
                    <option value="6" data-json="Q16_DP_NONDD.json">Q16 DP NON DD</a></option>
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
                    <option value="1">Show: All Respondents</option>
                </select>
                <select class="cDropdown-menu" id="selColor">
                    <option value="1">Color: Green</option>
                    <option value="2">Color: Red</option>
                </select>
                <button type="button" class="btn btn-primary" name="cmdSelect" id="cmdSelect2" >Show Data</button> 
            </div>
            <div class="cInfo">

            </div>
            <div id="ImgHolder">
                <img class="cHM_Image" src="" />
                <div class="cGridOuter" id="gridOuter"></div>

            </div>
        </div>        
    </body>
</html>