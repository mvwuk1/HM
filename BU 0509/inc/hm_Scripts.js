function fncDebug(intCode) {
    if (debug == true) {
        $("#debugStage").text(intCode);
    }
}
function fncCleanUp() {
    fncDebug(1);
    $(".cControlsOuter").hide();
    $(".cHM_Image").attr("src","");
    $(".cInfo").html("")
    $(".cGridRow").remove();
    selQVal = 0;
    selQJSON = "";
    strParProj = "OP10565";
    strParQid = "";
    strJSONFilename =  "";
    incResp = 1;
    dataArr = {"Rows":[]};
    dataArrMob = {"Rows":[]};
    iRows = 0;
    iCols = 0;
    tot = 0;
    strImgURL = '';
    parImageScaleBy = '';
    parImageSize = '';
    parHighlightSize ='';            		  
    parImageHeight = '';
    parImageWidth = '';
    respCount = 0;
    dataCount = 0;
    pcCount = 0;
    mobCount = 0;
    intBase = 0;    
}

function fncSetShade(SelBase,SelColor) {
    var intSelColor = parseInt(SelColor);
    var intSelBase = parseInt(SelBase);
    
    $(".tooltiptext").remove();
    $(".cGridCell").css("background-color","");

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
                var clkPCT = Number(parseFloat((intDataVal / parseInt(intBase) * 100))).toFixed(2);
                strTooltip = "<span class=\"tooltiptext\">Count: " + intDataVal + " pct: " + clkPCT + "%</span>";

                $(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).append(strTooltip); 
                $(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).css('background-color',strColor);
            }
        }
    }      
}

function fncFormatGrid() {
    fncDebug(6);
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
    var intGridRowWidth = parseInt(dataArr["Rows"][0]["Cells"].length) * parseInt(parHighlightSize) + 10;

    $('.cGridRow').css('width',intGridRowWidth + 'px');
    $('.cGridOuter').css('width',intGridRowWidth + 'px');
    $('.cGridCell').css('z-index','4');
    $('.cGridCell').css('width',parHighlightSize);
    $('.cGridCell').css('height',parHighlightSize);
    $('.cGridCell').css('border-radius','15%');
    $('.cGridCell').css('opacity','0.6');
    $('.cGridCell').css('display','inline-block');	
    $('.cGridCell').css('cursor','crosshair');
    fncDebug(7);
    $(".cControlsOuter").show();
}

function fncProcessJson() {
    
    $.getJSON(strJSONFilename, function( data ) {
        fncDebug(2);
        $.each( data, function(i) {
            fncDebug(3);
            respCount++;
            strParCurrId = data[i]['cid']
            if (data[i]['data'].length != 0 && strParCurrId.length !=0) {
                dataCount++;
                if (data[i]['data'][0]['parColumns'] > 25) {
                    pcCount++;
                    var blnParMobile = 0;

                    if (dataArr["Rows"].length == 0) {
                        strImgURL = data[i]['data'][0]["parImgURL"];
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
        $(".cHM_Image").attr("src",strImgURL);
        fncDebug(4);
        $(".cInfo").append("<h4>Image <span id=\"usedImg\">" + strImgURL + "<\span></h4>");
        $(".cInfo").append("<h4>Number of Respondents <span id=\"NumResp\">" + respCount + "<\span></h4>");
        $(".cInfo").append("<h4>Number of Respondents with Data <span id=\"NumData\">" + dataCount + "<\span></h4>");
        $(".cInfo").append("<h4>Number of Respondents with Non Mobile Data <span id=\"NumPC\">" + pcCount + "<\span></h4>");
        $(".cInfo").append("<h4>Number of Respondents with Mobile Data <span id=\"NumPC\">" + mobCount + "<\span></h4>");        
    });

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
    
    
    
} 