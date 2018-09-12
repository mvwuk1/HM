<!DOCTYPE html> 
<html>
<head>
    <?php
        include_once "inc/lib1.php"; // jQuery and Bootstrap
    ?>
    <style>
        .cContainer {
            padding: 20px;
        }
        .cGridCell .tooltiptext {
            visibility: hidden;
            /*width: 120px;*/
            height: 20px;
            font-size: 12px;
            background-color: black;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;
            width: 200px;
            /* Position the tooltip text - see examples below! */
            position: absolute;
            z-index: 5;
            opacity: 1.0;

        }

        /* Show the tooltip text when you mouse over the tooltip container */
        .cGridCell:hover .tooltiptext {
            visibility: visible;
        }        
    </style>
    <script>
        $(document).ready(function(){
            var strParProj = 'OP10565';
            var strParQid = 'Q16_Aqua_DD';
            var strJSONFilename =  "Q16_Aqua_NONDD.json";
            var incResp = 1;
            var dataArr = {"Rows":[]};
            var dataArrMob = {"Rows":[]};
            var iRows = 0;
            var iCols = 0;
            var tot = 0;
            var strImgURG = '';
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

            function fncCreateStruct(rows,cols) {
                for (rowLoop=0;rowLoop < rows; rowLoop++) {
                    dataArr["Rows"].push({"rowID" : rowLoop, "Cells" : []});
                    for (colLoop=0;colLoop < cols; colLoop++) {
                        dataArr["Rows"][rowLoop]['Cells'].push({"colID" : colLoop, "cellValue" : 0});
                    }
                }
            }
            function fncCreateStructMob(rows,cols) {
                for (rowLoop=0;rowLoop < rows; rowLoop++) {
                    dataArrMob["Rows"].push({"rowID" : rowLoop, "Cells" : []});
                    for (colLoop=0;colLoop < cols; colLoop++) {
                        dataArrMob["Rows"][rowLoop]['Cells'].push({"colID" : colLoop, "cellValue" : 0});
                    }
                }
            }
            
            function fncFormatGrid() {
                $('.cHM_Image').css(parImageScaleBy,parImageSize);
                var parImageHeight = $('.cHM_Image').height() + 'px';
                var parImageWidth = $('.cHM_Image').width() + 'px';
                
                $('.cImageHolder').css('z-index','1'); 
                $('.cGridOuter').css('z-index','2');
                $('.cGridOuter').css('display','block');
                $('.cGridOuter').css('position','relative');
                $('.cGridOuter').css('height',parImageHeight);
                
                $('.cGridOuter').css('top','-' + parImageHeight);
                $('.cGridOuter').css('font-size','0px')                             
                strHTML = "<table>";
                for (rowLoop=0;rowLoop < dataArr["Rows"].length; rowLoop++) {
                    strHTML += "<tr class=\"cGridRow\">";
                    for (colLoop=0;colLoop < dataArr["Rows"][0]["Cells"].length; colLoop++) {
                        strHTML += "<td class=\"cGridCell\" data-cval=\"" + dataArr['Rows'][rowLoop]['Cells'][colLoop]['cellValue']  + "\"></td>" ;
                    }
                    strHTML += "</tr>";
                }
                strHTML += "</table>";

                $('.cGridOuter').append(strHTML);
                //$('.cGridCell').css('background-color','rgb(0,125,0)');
                $('.cGridCell').css('z-index','4');
                $('.cGridRow').css('z-index','3');
                var intGridRowWidth = parseInt(dataArr["Rows"][0]["Cells"].length) * parseInt(parHighlightSize);

                $('.cGridRow').css('width',intGridRowWidth + 'px');
                $('.cGridOuter').css('width',intGridRowWidth + 'px');
                $('.cGridCell').css('z-index','4');
                $('.cGridCell').css('width',parHighlightSize);
                $('.cGridCell').css('height',parHighlightSize);
                $('.cGridCell').css('border-radius','15%');
                $('.cGridCell').css('opacity','0.6');
                $('.cGridCell').css('display','inline-block');	
                $('.cGridCell').css('cursor','crosshair');

            }

            function fncSetShade(intSelBase,intSelColor) {
                $(".tooltiptext").remove();
                intBase = 0;
                switch(intSelBase) {
                    case 1:
                        intBase = respCount;
                        break;
                    case 2:
                        intBase = dataCount;
                        break;
                    case 3:
                        intBase = pcCount;
                        break;
                    case 2:
                        intBase = mobCount;
                        break;
                }

                for (rowLoop=0;rowLoop < iRows; rowLoop++) {
                    for (colLoop=0;colLoop < iCols; colLoop++) {
                        var intDataVal = parseInt($(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).attr("data-cval"));
                        if (intDataVal !=0) {
                            intColVal = parseInt(parseFloat(intDataVal / parseInt(intBase)) * 155)+100;
                            switch(intSelColor) {
                                case 1:
                                    strColor = "rgb(0," + intColVal + ",0)";
                                    break;
                                case 2:
                                    strColor = "rgb(" + intColVal + ",0,0)";
                                    break;
                            }
                            //$(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).attr("data-base",intBase);
                            //$(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).attr("data-colVal",intColVal);
                            //$(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).attr("data-col",strColor);
                            strTooltip = "<span class=\"tooltiptext\">Count: " + intDataVal + " pct: " + Number(parseFloat((intDataVal / parseInt(intBase) * 100)).toFixed(2) + "%</span>"
                            $(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).append(strTooltip); 
                            $(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).css('background-color',strColor);
                        }
                    }
                }      
            }

            $('.cHM_Image').on('load', function() {
                fncFormatGrid();
                fncSetShade(3,1);
            });              


            $.getJSON(strJSONFilename, function( data ) {

                $.each( data, function(i) {
                    respCount++;
                    strParCurrId = data[i]['cid']
                    if (data[i]['data'].length != 0 && strParCurrId.length !=0) {
                        dataCount++;
                        if (data[i]['data'][0]['parColumns'] > 25) {
                            pcCount++;
                            var blnParMobile = 0;

                            if (dataArr["Rows"].length == 0) {
                                strImgURG = data[i]['data'][0]["parImgURL"];
                                parImageScaleBy = data[i]['data'][0]["parImageScaleBy"];
                                parImageSize = data[i]['data'][0]["parImageSize"];
                                parHighlightSize = data[i]['data'][0]["parHighlightSize"];


                                fncCreateStruct(data[i]['data'][0]['parRows'],data[i]['data'][0]['parColumns'])
                                iRows = data[i]['data'][0]['parRows'];
                                iCols = data[i]['data'][0]['parColumns'];
                            }
                        }
                        else {
                            var blnParMobile = 1;
                            mobCount ++;
                            if (dataArrMob["Rows"].length == 0) {
                                fncCreateStructMob(data[i]['data'][0]['parRows'],data[i]['data'][0]['parColumns'])
                            }                            
                        }
                        x=1
                        for (rowLoop=0;rowLoop < parseInt(data[i]['data'][0]['parRows']); rowLoop++) {
                        
                            for (colLoop=0;colLoop < data[i]['data'][0]['parColumns']; colLoop++) {
                                var intDataValue = parseInt(data[i]['data'][0]['Rows'][rowLoop]['Cells'][colLoop]['cellVal']);
                                //Add to Arrays here
                                
                                if (blnParMobile==0){
                                    tot = tot + intDataValue;
                                    dataArr["Rows"][rowLoop]['Cells'][colLoop]['cellValue'] = parseInt(dataArr["Rows"][rowLoop]['Cells'][colLoop]['cellValue']) + parseInt(intDataValue);
                                }
                                else {
                                    dataArrMob["Rows"][rowLoop]['Cells'][colLoop]['cellValue'] = parseInt(dataArrMob["Rows"][rowLoop]['Cells'][colLoop]['cellValue']) + parseInt(intDataValue);
                                }                                
                            }
                        }
                    }
                });
                $(".cHM_Image").attr("src",strImgURG);
                $(".cInfo").append("<h4>Number of Respondents <span id=\"NumResp\">" + respCount + "<\span></h4>");
                $(".cInfo").append("<h4>Number of Respondents with Data <span id=\"NumData\">" + dataCount + "<\span></h4>");
                $(".cInfo").append("<h4>Number of Respondents with Non Mobile Data <span id=\"NumPC\">" + pcCount + "<\span></h4>");
                $(".cInfo").append("<h4>Number of Respondents with Mobile Data <span id=\"NumPC\">" + mobCount + "<\span></h4>");
            });
        });
    </script>
</head>
	<body>
    <div class="cContainer">           
        <div class="cOuter">
            <div class="cControlsOuter">
                
            </div>
            <div class="cInfo">

            </div>
            <div id="ImgHolder">
                <img class="cHM_Image" src="" />
                <div class="cGridOuter" id="gridOuter"></div>

            </div>
        </div>
    </div>
	</body>
</html>