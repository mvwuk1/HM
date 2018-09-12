
function fncBtnDisable() {
    $('.cLogoutCmd').waitMe({
        effect: 'none',
        text: 'Processing',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        waitTime: -1,
        height: '35px'
    });
    $("#cmdSelect").prop('disabled', 'disabled');
    $("#cmdSelect2").prop('disabled', 'disabled');
    $("#btnSave1").prop('disabled', 'disabled');
    $("BtnColor").prop('disabled', 'disabled');

}
function fncBtnEnable() {
    $('.cLogoutCmd').waitMe('hide');
    $("#cmdSelect").prop('disabled','');
    $("#cmdSelect2").prop('disabled','' );
    $("#btnSave1").prop('disabled', '');
    $("BtnColor").prop('disabled', '');
}
function fncDebug(strCode) {
    if (debug == true) {
        $("#debugStage").text(strCode);
    }
}
function fncColorPicker() {
    $('#picker').farbtastic('#color');
    
}

function fncValidateInput() {

}
function fncCleanUp() {
    fncDebug("1 Start");
    $(".cControlsOuter").hide();
    $(".cHM_Image").attr("src","");
    $(".cInfo").html("")
    $(".cGridRow").remove();
    selQVal = 0;
    selQJSON = "";
    strParProj = "OP10565";
    strParQid = "";
    strJSONFilename = "";
    incResp = 1;
    dataArr = {"Rows":[]};
    dataArrMob = {"Rows":[]};
    iRows = 0;
    iCols = 0;
    tot = 0;
    strImgURL = '';
    blnSavable = false;
    strLocalImgURL = '';
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
    intOffSet = 0;    
    fncDebug("1 End");        
}

function fncSetShade(selShow,SelBase,SelColor) {

    fncDebug("s3");
    var intShow = parseInt(selShow);
    var intSelColor = parseInt(SelColor);
    var intSelBase = parseInt(SelBase);
    intMinClick = $("#minClick").val();

    $(".tooltiptext").remove();
    $(".cGridCell").css("background-color","");

    switch(intShow) {
        case 3:
            strSel = "#gridOuter_non";
            $('#gridOuter_mob').hide();
            $('#gridOuter_non').show();
            $('#gridOuter_mob').css('z-index','1');
            $('#gridOuter_mob').find('.cGridRow').css('z-index','1');
            $('#gridOuter_mob').find('.cGridCell').css('z-index','1');
        
            iRows = dataArr["Rows"].length;
            icols = dataArr["Rows"][0]["Cells"].length;
            break;
        case 4:
            strSel = "#gridOuter_mob";
            $('#gridOuter_mob').show();
            $('#gridOuter_non').hide();
            $('#gridOuter_non').css('z-index','1');
            $('#gridOuter_non').find('.cGridRow').css('z-index','1');
            $('#gridOuter_non').find('.cGridCell').css('z-index','1');            
            iRows = dataArrMob["Rows"].length;
            icols = dataArrMob["Rows"][0]["Cells"].length;            
            break;
    }
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
        case 4:
            intBase = mobCount;
            break;
    }
    fncDebug("s4");

    for (rowLoop=0;rowLoop < iRows; rowLoop++) {

        for (colLoop=0;colLoop < iCols; colLoop++) {
            var intDataVal = parseInt($(strSel).find(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).attr("data-cval"));
            if (intDataVal !=0) {
                if (intDataVal >= intMinClick) {
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

                    $(strSel).find(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).append(strTooltip); 
                    $(strSel).find(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).css('background-color',strColor);
                    //$(".tooltiptext").css("z-index","99");
                }
            }
        }
    }
    fncDebug("s5"); 
    $(strSel).css('z-index','1');
    $(strSel).find('.cGridRow').css('z-index','2');
    $(strSel).find('.cGridCell').css('z-index','3');            
    $(strSel).find(".tooltiptext").css("z-index","99");
    $(strSel).find(".tooltiptext").css('opacity','1.0');
    fncBtnEnable();     
    fncDebug("s6");     
}

function fncSetShadeV2(selShow,SelBase,SelColor) {
    fncBtnDisable();
    fncDebug("s3");
    var intShow = parseInt(selShow);
    var intSelBase = parseInt(SelBase);
    intMinClick = parseInt($("#minClick").val());
    intOffSet = parseInt($("#shadeOffset").val());
    $(".tooltiptext").remove();
    $(".cGridCell").css("background-color","");

    switch(intShow) {
        case 3:
            strSel = "#gridOuter_non";
            $('#gridOuter_mob').hide();
            $('#gridOuter_non').show();
            $('#gridOuter_mob').css('z-index','1');
            $('#gridOuter_mob').find('.cGridRow').css('z-index','1');
            $('#gridOuter_mob').find('.cGridCell').css('z-index','1');
        
            iRows = dataArr["Rows"].length;
            icols = dataArr["Rows"][0]["Cells"].length;
            break;
        case 4:
            strSel = "#gridOuter_mob";
            $('#gridOuter_mob').show();
            $('#gridOuter_non').hide();
            $('#gridOuter_non').css('z-index','1');
            $('#gridOuter_non').find('.cGridRow').css('z-index','1');
            $('#gridOuter_non').find('.cGridCell').css('z-index','1');            
            iRows = dataArrMob["Rows"].length;
            icols = dataArrMob["Rows"][0]["Cells"].length;            
            break;
    }
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
        case 4:
            intBase = mobCount;
            break;
    }
    fncDebug("s4");

    for (rowLoop=0;rowLoop < iRows; rowLoop++) {

        for (colLoop=0;colLoop < iCols; colLoop++) {
            var intDataVal = parseInt($(strSel).find(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).attr("data-cval"));
            if (intDataVal !=0) {
                if (intDataVal >= intMinClick) {
                    
                    var clkPCT = Number(parseFloat((intDataVal / parseInt(intBase) * 100))).toFixed(2);
                    var cellOpacity = Number(Math.round(parseFloat((intDataVal / parseInt(intBase) * 100)) + intOffSet) / 100).toFixed(2);
                    strTooltip = "<span class=\"tooltiptext\">Count: " + intDataVal + " pct: " + clkPCT + "%</span>";

                    $(strSel).find(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).append(strTooltip); 
                    $(strSel).find(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).css('background-color',SelColor);
                    $(strSel).find(".cGridRow").eq(rowLoop).find(".cGridCell").eq(colLoop).css('opacity',cellOpacity);
                    //$(".tooltiptext").css("z-index","99");
                }
            }
        }
    }
    fncDebug("s5"); 
    $(strSel).css('z-index','1');
    $(strSel).find('.cGridRow').css('z-index','2');
    $(strSel).find('.cGridCell').css('z-index','3');            
    $(strSel).find(".tooltiptext").css("z-index","99");
    $(strSel).find(".tooltiptext").css('opacity','1.0');
    fncBtnEnable();    
    fncDebug("s6");     
}

function fncFormatGrid() {
    fncDebug(6);
    $('.cGridOuter').html('');
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
    //var position = $('.cHM_Image').position();
    //$('.cGridOuter').css('position','absolute');
    //$('.cGridOuter').css('top',position.top);                   
    //Non Mobile
    parHighlightSize = Math.round($('.cHM_Image').height() / dataArr["Rows"].length);
    strHTML = "<table>";
    for (rowLoop=0;rowLoop < dataArr["Rows"].length; rowLoop++) {
        strHTML += "<tr class=\"cGridRow\">";
        for (colLoop=0;colLoop < dataArr["Rows"][0]["Cells"].length; colLoop++) {
            strHTML += "<td class=\"cGridCell\" data-cval=\"" + dataArr['Rows'][rowLoop]['Cells'][colLoop]['cellValue']  + "\"></td>" ;
        }
        strHTML += "</tr>";
    }
    strHTML += "</table>";

    $('#gridOuter_non').append(strHTML);
     $('#gridOuter_non').find('.cGridCell').css('width',parHighlightSize);
    $('#gridOuter_non').find('.cGridCell').css('height',parHighlightSize);

    //Mobile
    parHighlightHeight = Math.round($('.cHM_Image').height() / dataArrMob["Rows"].length);
    parHighlightWidth = Math.round($('.cHM_Image').width() / dataArrMob["Rows"][0]["Cells"].length);
    strHTML = "<table>";
    for (rowLoop=0;rowLoop < dataArrMob["Rows"].length; rowLoop++) {
        strHTML += "<tr class=\"cGridRow\">";
        for (colLoop=0;colLoop < dataArrMob["Rows"][0]["Cells"].length; colLoop++) {
            strHTML += "<td class=\"cGridCell\" data-cval=\"" + dataArrMob['Rows'][rowLoop]['Cells'][colLoop]['cellValue']  + "\"></td>" ;
        }
        strHTML += "</tr>";
    }
    strHTML += "</table>";

    $('#gridOuter_mob').append(strHTML);

    $('#gridOuter_mob').find('.cGridCell').css('width',parHighlightWidth);
    $('#gridOuter_mob').find('.cGridCell').css('height',parHighlightHeight);

    var intGridRowWidth = $('.cHM_Image').height() + 10;

    $('.cGridRow').css('width',intGridRowWidth + 'px');
    $('.cGridOuter').css('width',intGridRowWidth + 'px');

    $('.cGridCell').css('border-radius','15%');
    $('.cGridCell').css('opacity','0.6');
    $('.cGridCell').css('display','inline-block');	
    $('.cGridCell').css('cursor','crosshair');
    $('.cGridOuter').css('background-color','transparent');
    $('.cGridRow').css('background-color','transparent');
    $('.cGridCell').css('background-color','transparent');
    //$('#gridOuter_mob').find('.cGridCell').css('background-color','rgb(0,125,0)');
    //$('#gridOuter_non').find('.cGridCell').css('background-color','rgb(0,125,0)');

    $('#gridOuter_non').hide();
    $('#gridOuter_mob').hide();
    fncDebug(7);
    $(".cControlsOuter").show();
    fncBtnEnable();      
}

function fncProcessJson() {
    fncDebug("1c ");
    fncDebug(strJSONFilename);
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
                        intStartName = strImgURL.lastIndexOf("/");
                        strLocalImgURL = 'images' + strImgURL.substr(intStartName, 250);
                        //testImage(strLocalImgURL);
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
        $(".cHM_Image").attr("src",strLocalImgURL);
        fncDebug(4);
        if (debug == true) {
            $(".cInfo").append("<h4>Data <span id=\"dataFile\">" + strJSONFilename + "<\span></h4>");
        }
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