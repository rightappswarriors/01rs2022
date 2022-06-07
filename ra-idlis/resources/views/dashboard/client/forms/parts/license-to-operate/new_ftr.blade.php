<script>
var mserv_cap = JSON.parse('{!!addslashes($serv_cap)!!}')

// START OF DATA INITIALIZATION FOR VIEWING EXISTING APPLICATION
    window.addEventListener('click', function(e) {
        initialCheck()

        if( $('input[name="hgpid"]:checked').val() == 18 || $('input[name="hgpid"]:checked').val() == 17){
            document.getElementById("nofpahr").setAttribute('hidden','hidden')
        }else{
            document.getElementById("nofpahr").removeAttribute('hidden')
        }
        
    });
    setTimeout(function(){
        initialCheck()
    }, 1000);


    setTimeout(function(){
            var first = document.getElementById("clickable");
    first.click(); 
    }, 3000);

    function initialCheck(){
             if(document.querySelector('input[name="hgpid"]:checked') === null){
                    var first = document.getElementsByName("hgpid")[0];
                    first.checked = true;
                    first.click();     
                    getChargesPerApplication()
                    getFacServCharge()
            }else{
                getChargesPerApplication()
                setTimeout(function(){
                    getFacServCharge()
                }, 1000);
            }
    }

// END OF DATA INITIALIZATION FOR VIEWING EXISTING APPLICATION

    document.getElementsByName('areacode').value = 3;
  
    var ghgpid = document.getElementsByName('hgpid')
    var curAppid = ""
    var mhfser_id = "LTO"
    var aptid = document.getElementById("aptidnew").value
    
      var  ghgpid = document.getElementsByName('hgpid');
      (function ( $ ) { 
      $(document).on('change','#same', function(event){
				if($(this).prop('checked') == true){
					if($("#street_name").val() != null && 
                    $("#cmid option:selected").val() != "" && 
                    $("#provid option:selected").val() != "" && 
                    $("#brgyid option:selected").val() != "" &&
                     $("#rgnid option:selected").val() != ""){

					$('#mailingAddress').val(($('#street_number').val() != "" ? 
                    $('#street_number').val() : "") + " " + 
                    $("#street_name").val() + " " +
                    $("#brgyid option:selected").text().toUpperCase() + " " + 
                    $("#cmid option:selected").text().toUpperCase() + " " +
                    $("#provid option:selected").text().toUpperCase() + " " + 
                     $("#rgnid option:selected").text().toUpperCase());
				
                } else {
						this.checked = false;
    					event.preventDefault();
						alert('Please select facility address first!');
					}
				} else {
					$('#mailingAddress').val('');
				}
			});
        }( jQuery ));

    function offMailDup (){
      var box =  document.getElementById('same');
      var street_name =  document.getElementById('street_name');
      var cmid =  document.getElementById('city_monicipality');
      var provid =  document.getElementById('province');
      var brgyid =  document.getElementById('brgy');
      var rgnid =  document.getElementById('region');
      var mailingAddress =  document.getElementById('official_mail_address');

            if(box.checked){
                if( street_name.value == "" && 
                cmid.value == "" && 
                provid.value == "" && 
                brgyid.value == "" && 
                rgnid.value == "" ){
                
                    box.checked = false;
                                event.preventDefault();
                                alert('Please select facility address first!');

                }else{

                    mailingAddress.value = street_name.value + " " +
                    cmid.options[cmid.selectedIndex].text + " " +
                    provid.options[provid.selectedIndex].text + " " +
                    brgyid.options[brgyid.selectedIndex].text + " " +
                    rgnid.options[rgnid.selectedIndex].text + " " ;

                }
            
            }else{
                mailingAddress.value = " "
            
            }
    }

    function ASCfacilities (){

            var newDiv = document.createElement("div");
            newDiv.setAttribute("id", "hgpid1");
            newDiv.setAttribute("class", "custom-control");
            document.getElementById("forAmb").appendChild(newDiv);

            var result = mserv_cap.filter(function(v) {
                return v.hgpid == 1;
            })

            result.map((it) => {
                var newDiv = document.createElement("div");
                newDiv.setAttribute("class", "row custom-control  mr-sm-2");
                newDiv.setAttribute("id", "hgpid1-" + it.facid);
                document.getElementById("hgpid1").appendChild(newDiv);

                var x = document.createElement("INPUT");
                x.setAttribute("id", it.facid);
                x.setAttribute("type", "checkbox");
                x.setAttribute("value", it.facid);
                x.setAttribute("name", "facid");
                x.setAttribute("onclick", "getFacServCharge()");
                x.setAttribute("class", "custom-control-input exAddRenew");
                document.getElementById("hgpid1-" + it.facid).appendChild(x);

                var label = document.createElement("Label");
                label.setAttribute("for", it.facid);
                label.setAttribute("class", "custom-control-label");
                label.innerHTML = it.facname;

                var newInput = document.getElementById(it.facid)
                insertAfter(newInput, label);
        })
    }
   
    //display subfacilities/services/add ons
    function type_of_fac(selected) {
        
        var nm = document.getElementById("noofmain")
		
        if( $('input[name="hgpid"]:checked').val() == 6 ){
                if(nm.value == null || nm.value == undefined  || nm.value == " "|| !nm.value){
                document.getElementById("noofmain").value = 1
                }
        }else{
            if(nm.value == null || nm.value == undefined  || nm.value == " "|| !nm.value || '{!!isset($fAddress)&&(count($fAddress) == 0)!!}'){
                document.getElementById("noofmain").value = null
            }
        }

        const data = ["hospClassif", "forHosp", "ambuDetails", "ancillary", "addOnServe", "ambulSurgCli", "clinicLab", "dialysisClinic", "otherClinicService"];
        data.map((h) => {
            document.getElementsByClassName(h)[0].setAttribute("hidden", "hidden")
        });
        // initila selection from db
        document.getElementById(selected).checked = true;

        $('#hgpid1').remove()
        removeAmbuRows()
        deselectOpts('anxsel')
        deselectOpts('facid')
        document.querySelector('select[data-funcid="duplicate"]').value = null;

        document.getElementById('serv_chg').innerHTML = '<tr><td colspan="2">No Services Selected.</td></tr>';
        document.getElementById('tempAppCharge').value = " ";
        document.getElementById('tempAppChargeHgpid').value = " ";
        document.getElementById('tempAppChargeAmb').value = " ";
        removeOtherServCont();

        selected == '6' ? ifHospital("show") : " ";
        selected == '2' || selected == '7' || selected == '4' || selected == '28' ? clinicServAndLab("show", selected) : " ";
        selected == '17' ? clinicServAndLabAmbu("show", selected) : " ";
        selected == '18' ? clinicServAndLabAmbu("show", selected) : " ";
        selected == '1' ? ifAmbuSurg("show") : " ";
        selected == '5' ? ifHemoClinic("show") : " ";

        if(selected == 5){
            document.getElementById("noDal").removeAttribute("hidden")
            document.getElementById("noDal").removeAttribute("class")
            document.getElementById("noofdialysis").value = 0;
            
        }else{
            document.getElementById("noDal").setAttribute("hidden", "hidden")
            document.getElementById("noofdialysis").value = null;
        }
        
        //No charges with subclasses
         if(selected != 5) 
         {
			// alert('getcharges here');
            getChargesPerApplication()
         }
    }


    function getChargesPerApplication() {

        //mhfser_id = Type of Application: LTO, COA, CON, PTC, COR, etc.
        //document.getElementById("aptidnew").value or aptid: IN for initial or R for Renewal
        let sArr = ['_token=' + document.getElementsByName('_token')[0].value, 'appid=' + curAppid, 'aptid=' + document.getElementById("aptidnew").value, 'hfser_id=' + mhfser_id],
            ghgpid = document.getElementsByName('hgpid');
           
        if (ghgpid != null || ghgpid != undefined) {
            for (let i = 0; i < ghgpid.length; i++) {
                if (ghgpid[i].checked) {
                    //ghgpid[i].value=Type of Facilities/Categories
                    sArr.push('hgpid[]=' + ghgpid[i].value);
                }
            }
        }
        
        sendRequestRetArr(sArr, "{{asset('client1/request/customQuery/getChargesPerApplication')}}", "POST", true, {
            functionProcess: function(arr) {

                        const subclass = $('#subclass').val()  == "" ||  $('#subclass').val() == undefined ? '{!!((count($fAddress) > 0) ? $fAddress[0]->subClassid: "")!!}' : $('#subclass').val();//appchargetemp

                        var ta=[]; //appchargetemp

                         //appchargetemp
                         const distinctArr = Array.from(new Set(arr.map(s => s.chg_desc))).map(chg_desc => {
                               
                               return {
                                chg_desc: chg_desc,
                               amt: subclass == "ND" ? 0 :  arr.find(s =>
                                       s.chg_desc === chg_desc).amt,
                               chgapp_id: arr.find(s =>
                                       s.chg_desc === chg_desc).chgapp_id
                       }
                       })
                
                let not_serv_chg = document.getElementById('not_serv_chg');
                if (not_serv_chg != undefined || not_serv_chg != null) {
                    if (arr.length > 0) {
                        not_serv_chg.innerHTML = '';
                        for (let i = 0; i < arr.length; i++) {
                            ta.push({reference : distinctArr[i]['chg_desc'],amount: distinctArr[i]['amt'], chgapp_id:  distinctArr[i]['chgapp_id'] }) //appcharge
                            not_serv_chg.innerHTML += '<tr><td>[' + distinctArr[i]['chgapp_id'] +' '+ distinctArr[i]['chg_code'] + ']' + distinctArr[i]['chg_desc'] + '</td><td>&#8369;&nbsp;<span>' + numberWithCommas(subclass == "ND" ? 0 : (parseInt(distinctArr[i]['amt'])).toFixed(2)) + '</span></td></tr>';
                        }
                    } else {
                        not_serv_chg.innerHTML = '<tr><td colspan="2">Chosen facility has no Registration fee Required.</td></tr>';
                    }
                    document.getElementById('tempAppChargeHgpid').value = JSON.stringify(ta)//appchargetemp

                }
            }
        });

    }

    function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }   

    function getaddonsValues(){
     var addons =   document.getElementsByName('addOnServ');
     var getAdd = [];

        for(var i = 1 ; i < addons.length; i++){
            getAdd.push(addons[i].value);
        }
       return getAdd

    }

    function deselectOpts (name){
        
                var ele;
        
                if(name == 'anxsel'){
                 ele=document.getElementsByClassName(name);  
                }else if(name == 'facid'){
                    ele=document.getElementsByName(name);
                }

                for(var i=0; i<ele.length; i++){  
                    if(ele[i].type=='radio') { 
                        ele[i].checked=false;
                    }
                    if(ele[i].checked){
                        ele[i].checked=false;
                    }
                }  
    }

function getFacServCharge (val = null){

    getChargesPerApplication()
    getChargesPerAmb()

    setTimeout(function(){  
        var adser = document.getElementsByName("addOnServ");

        var chkad = 'no';
            for(var ad = 0; ad < adser.length ; ad++){
                if(adser[ad].value == 'H3ADC'){
                    chkad = 'yes';
                }
            }

        var l3 = document.getElementById("H3ADC");
        
            //if(l3 || chkad == 'yes'){
                try{
                    if(13!=null)
                    {
                        if(l3.checked == true || chkad == 'yes'){
                        document.getElementById("noDal").removeAttribute("hidden")
                        document.getElementById("noDal").removeAttribute("class")
                        }else{
                            document.getElementById("noDal").setAttribute("hidden", "hidden")
                            document.getElementById("noofdialysis").value = null;
                        }
                    }
                }
                catch {}
                
                
        // }else{
            //        document.getElementById("noDal").setAttribute("hidden", "hidden")
        //         document.getElementById("noofdialysis").value = null;
        // }
    }, 2000);

    var addons= [];

    var asc = document.getElementById("H3AmbulatorySurgicalClinic");
    var ascType = document.getElementById("1");

    if(asc ||  ascType?.checked == true){
        if (asc?.checked == true || ascType?.checked == true){

            document.getElementsByClassName('ambulSurgCli')[0].removeAttribute("hidden")
            var hgp1 = document.getElementById("hgpid1")

            if(hgp1 == null)
            {
                ASCfacilities ()
            }
        }else{
            $('#hgpid1').remove()
            document.getElementsByClassName('ambulSurgCli')[0].setAttribute("hidden", "hidden")
        }
    }
    if(val == 2){
        addons = getaddonsValues();
    }

    var facids = getCheckedValue('facid') 
    var anxsel = getCheckedValue('anxsel') 
    var arrCol = facids;
    var arrCol2 = anxsel;

    let serv_chg = document.getElementById('serv_chg');

    //Ambulatory Surgical Clinic
    if( ascType.checked) 
    {
        var ta=[];
        //alert(ascType.getCheckedValue());
        const distinctArr = [['chgapp_id', 'facname','amt']]; 
        distinctArr[0]['chgapp_id']='48';
        distinctArr[0]['facname']='Ambulatory Surgical Clinic';
        distinctArr[0]['amt']='14000.00';
        var amt = distinctArr[0]['amt'];

        serv_chg.innerHTML = '';
        
        if(distinctArr[i]['chgapp_id']){
            ta.push({reference : distinctArr[i]['facname'],amount: amt, chgapp_id:  distinctArr[i]['chgapp_id'] }) //appcharge

            serv_chg.innerHTML += '<tr><td>[<strong>'  + distinctArr[i]['chgapp_id'] + '</strong>] ' + distinctArr[i]['facname'] + '</td><td>&#8369;&nbsp;<span>' + numberWithCommas(subclass == "ND" ? 0 : (parseInt(amt)).toFixed(2)) + '</span></td></tr>';
        }
    }
    //Ambulance Service Provider
    else if (document.getElementById("34").checked)
    {
        var ta=[];
        //alert(ascType.getCheckedValue());
        const distinctArr = [['chgapp_id', 'facname','amt']]; 
        distinctArr[0]['chgapp_id']='83';
        distinctArr[0]['facname']='Ambulance Service Provider';
        distinctArr[0]['amt']='15000.00';
        var amt = distinctArr[0]['amt'];

        serv_chg.innerHTML = '';
        
        if(distinctArr[i]['chgapp_id']){
            ta.push({reference : distinctArr[i]['facname'],amount: amt, chgapp_id:  distinctArr[i]['chgapp_id'] }) //appcharge

            serv_chg.innerHTML += '<tr><td>[<strong>'  + distinctArr[i]['chgapp_id'] + '</strong>] ' + distinctArr[i]['facname'] + '</td><td>&#8369;&nbsp;<span>' + numberWithCommas(subclass == "ND" ? 0 : (parseInt(amt)).toFixed(2)) + '</span></td></tr>';
        }
    }
    else if(arrCol.length > 0)
    {
        let thisFacid = [], appendToPayment = ['groupThis'], hospitalFaci = ['H','H2','H3'];
        let sArr = ['_token='+document.getElementsByName('_token')[0].value, 'appid='+curAppid, 'hfser_id='+mhfser_id, 'aptid='+ document.getElementById("aptidnew").value];
        
        if(Array.isArray(arrCol)) {
            for(let i = 0; i < arrCol.length; i++) {
                sArr.push('facid[]='+arrCol[i]); 
                thisFacid.push(arrCol[i]);
            } 
        }

        if(arrCol2.length > 0){
            if(Array.isArray(arrCol2)) {
                for(let i = 0; i < arrCol2.length; i++) {
                    sArr.push('facid[]='+arrCol2[i]); 
                    thisFacid.push(arrCol2[i]);
                } 
            }
        }

        if(addons.length > 0){
            if(Array.isArray(addons)) {
                for(let i = 0; i < addons.length; i++) {
                    sArr.push('facid[]='+addons[i]); 
                    thisFacid.push(addons[i]);
                } 
            }
        }

        if(!document.getElementById('6').checked){
            for(let j = 0; j < thisFacid.length; j++) {
                if($.inArray(thisFacid[j], hospitalFaci) < 0){
                    if(document.getElementsByName('ambtyp').length){
                        for(let k = 0; k < document.getElementsByName('ambtyp').length; k++) {
                            // document.getElementsByName('ambtyp')[k].value = "";
                        } 
                    }
                }
            } 
        }

        setTimeout(function(){ 
            sendRequestRetArr(sArr, "{{asset('client1/request/customQuery/getServiceCharge')}}", "POST", true, {
                functionProcess: function(arr) {
                    const subclass = $('#subclass').val()  == "" ||  $('#subclass').val() == undefined ? '{!!((count($fAddress) > 0) ? $fAddress[0]->subClassid: "")!!}' : $('#subclass').val();//appchargetemp
                    const owns = $('#ocid').val()  == "" ||  $('#ocid').val() == undefined ? '{!!((count($fAddress) > 0) ? $fAddress[0]->ocid: "")!!}' : $('#ocid').val();//appchargetemp
                    var ta=[]; //appchargetemp

                    const distinctArr = Array.from(new Set(arr.map(s => s.facname))).map(facname => {
                                        return {
                                            facid:  arr.find(s =>
                                                    s.facname === facname).facid,
                                            facname: facname,
                                            amt: subclass == "ND" ? 0 :  arr.find(s =>
                                                    s.facname === facname).amt,
                                            chgapp_id: arr.find(s =>
                                                    s.facname === facname).chgapp_id
                                        }})
                                        
                    if(serv_chg != undefined || serv_chg != null) {

                        if(distinctArr.length > 0) {

                            serv_chg.innerHTML = '';

                            for(let i = 0; i < distinctArr.length; i++) {

                                serv_chg.innerHTML = '';

                                for (let i = 0; i < distinctArr.length; i++) {
                                    
                                    var amt = parseFloat(distinctArr[i]['amt']) + 0;

                                    if(isNaN(amt)){
                                        amt = 0;
                                    }
                                    if(  owns == "G" ){
                                        if(distinctArr[i]['facid'] == "H" ||distinctArr[i]['facid'] == "H2" || distinctArr[i]['facid'] == "H3" ){
                                            amt = 0
                                        }
                                        
                                    }
                                    //Services Fee Display
                                    if(distinctArr[i]['chgapp_id']){
                                        ta.push({reference : distinctArr[i]['facname'],amount: amt, chgapp_id:  distinctArr[i]['chgapp_id'] }) //appcharge
                                        serv_chg.innerHTML += '<tr><td>[<strong>'  + distinctArr[i]['chgapp_id'] + '</strong>] ' + distinctArr[i]['facname'] + '</td><td>&#8369;&nbsp;<span>' + numberWithCommas(subclass == "ND" ? 0 : (parseInt(amt)).toFixed(2)) + '</span></td></tr>';
                                    }
                                }
                            }
                        } else {
                            serv_chg.innerHTML = '<tr><td colspan="2">No Services selected.</td></tr>';
                        }
                    }
                    
                    document.getElementById('tempAppCharge').value = JSON.stringify(getUnique(ta,'chgapp_id'))//appchargetemp
                }
            });
        }, 1000);

    } else {
        serv_chg.innerHTML = '<tr><td colspan="2">No Payment Necessary.</td></tr>';
    }

}

    function getUnique(arr, comp) {

        // store the comparison  values in array
        const unique =  arr.map(e => e[comp])

        // store the indexes of the unique objects
        .map((e, i, final) => final.indexOf(e) === i && i)

        // eliminate the false indexes & return unique objects
        .filter((e) => arr[e]).map(e => arr[e]);

        return unique;
    }

    function getCheckedValue(groupName) {

        var radios;
        if(groupName == "anxsel"){
             radios = document.getElementsByClassName(groupName);
        }else{
             radios = document.getElementsByName(groupName);
        }

        // console.log("radios",radios)

        var rad = []
        for( i = 0; i < radios.length; i++ ) {
            if( radios[i].checked ) {
                rad.push(radios[i].value);
                
            }
        }

        // console.log("checked", rad)
        return rad;
    }
   
    function ifHospital(specs) {

        if (specs == "show") {
            
            const show = ["hospClassif", "forHosp", "ambuDetails", "addOnServe"];
            // const show = ["hospClassif", "forHosp", "ambuDetails"]; //7-24/2021
            show.map((h) => {
                
                document.getElementsByClassName(h)[0].removeAttribute("hidden")
            });
            
            
        } else {
            const hide = ["hospClassif", "forHosp", "ambuDetails", "ancillary", "addOnServe"];
            hide.map((h) => {
                document.getElementsByClassName(h)[0].setAttribute("hidden", "hidden")
            });
        }

    }

    function ifAmbuSurg(specs) {
        const data = ["ambulSurgCli", "ambuDetails", "clinicLab"];
        if (specs == "show") {
            ASCfacilities ()
            data.map((h) => {
                document.getElementsByClassName(h)[0].removeAttribute("hidden")
            });
        } else {
            data.map((h) => {
                document.getElementsByClassName(h)[0].setAttribute("hidden", "hidden")
            });
        }

    }

    function ifHemoClinic(specs) {

        

        const data = ["dialysisClinic", "addOnServe", "clinicLab"];
        //place also getting add on service data here
        $('#hgpid5').remove()
        removeAddOnRows()
        renewAddOnSelect("HDS")
        if (specs == "show") {
            data.map((h) => {
                document.getElementsByClassName(h)[0].removeAttribute("hidden")
            });

            var newDiv = document.createElement("div");
           
            newDiv.setAttribute("id", "hgpid5");
            document.getElementById("hgpid5-cont").appendChild(newDiv);

           var result = mserv_cap.filter(function(v) {
                return v.hgpid == 5;
            })

            result.map((it) => {
                var x = document.createElement("INPUT");
                x.setAttribute("id", it.facid);
                x.setAttribute("type", "radio");
                x.setAttribute("value", it.facid);
                x.setAttribute("name", "facid");
                x.setAttribute("onclick", "getFacServCharge()");
                // x.setAttribute("checked", "checked");
                x.setAttribute("class", "custom-control-input");
                document.getElementById("hgpid5").appendChild(x);


                var label = document.createElement("Label");
                label.setAttribute("for", it.facid);
                label.setAttribute("class", "custom-control-label");
                label.innerHTML = it.facname;

                var newInput = document.getElementById(it.facid)
                insertAfter(newInput, label);
            })
        } else {
            data.map((h) => {
                document.getElementsByClassName(h)[0].setAttribute("hidden", "hidden")
            });
        }

    }

    function clinicServAndLab(specs, selected) {

        const data = ["otherClinicService", "clinicLab"];
       
        if (specs == "show") {
            data.map((h) => {
                document.getElementsByClassName(h)[0].removeAttribute("hidden")

            });
        } else {
            data.map((h) => {
                document.getElementsByClassName(h)[0].setAttribute("hidden", "hidden")
            });
        }


        getOtherServices(selected)
    }

    function clinicServAndLabAmbu(specs, selected) {
        const data = ["otherClinicService", "clinicLab", "ambuDetails"];
        if (specs == "show") {
            data.map((h) => {

                document.getElementsByClassName(h)[0].removeAttribute("hidden")

            });
        } else {
            data.map((h) => {
                document.getElementsByClassName(h)[0].setAttribute("hidden", "hidden")
            });
        }

        getOtherServices(selected)
    }


    function insertAfter(referenceNode, newNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }

    function sel_hosp_class(selected) {
        var myobj = document.getElementById("hgpid6-cont");
        if (myobj) {
            myobj.remove();
        }

        document.getElementsByClassName("showifHospital-class")[0].removeAttribute("hidden");
        var e = document.getElementById("funcid");
        var funcid = e.value;
        var result = [];
        var radio = " ";

        // delete hgpid6-cont first here

        var newDiv = document.createElement("div");
        newDiv.setAttribute("id", "hgpid6-cont");
        document.getElementById("hgpid6").appendChild(newDiv);


        if (selected == 2) {
            document.getElementsByClassName("ancillary")[0].setAttribute("hidden","hidden")
            var newDiv = document.createElement("div");
            newDiv.setAttribute("class", "custom-control custom-radio mr-sm-2");
            newDiv.setAttribute("id", "hgpid6-new");
            document.getElementById("hgpid6-cont").appendChild(newDiv);

            result = mserv_cap.filter(function(v) {
                return v.hgpid == 6 && v.forSpecialty == 1;
            })
            result.map((it) => {
                var x = document.createElement("INPUT");
                x.setAttribute("id", it.facid);
                x.setAttribute("type", "radio");
                x.setAttribute("value", it.facid);
                x.setAttribute("name", "facid");
                x.setAttribute("onclick", "getFacServCharge()");
                x.setAttribute("class", "custom-control-input");
                document.getElementById("hgpid6-new").appendChild(x);


                var label = document.createElement("Label");
                label.setAttribute("for", it.facid);
                label.setAttribute("class", "custom-control-label");
                label.innerHTML = it.facname;

                var newInput = document.getElementById(it.facid)
                insertAfter(newInput, label);
            })

        } else {
            var hlevel = [{
                id: "H"
            }, {
                id: "H2"
            }, {
                id: "H3"
            }];
          

            mserv_cap.map((it) => {
                hlevel.map((hl) => {
                    if (it.facid == hl.id) {
                        var newDiv = document.createElement("div");
                        newDiv.setAttribute("class", "custom-control custom-radio mr-sm-2");
                        newDiv.setAttribute("id", "hgpid6-" + hl.id);
                        document.getElementById("hgpid6-cont").appendChild(newDiv);

                        var x = document.createElement("INPUT");
                        x.setAttribute("id", it.facid);
                        x.setAttribute("type", "radio");
                        x.setAttribute("value", it.facid);
                        x.setAttribute("name", "facid");
                        x.setAttribute("onclick", "getAncillary(this.id, 6)");
                        x.setAttribute("class", "custom-control-input");
                        document.getElementById("hgpid6-" + hl.id).appendChild(x);

                        var label = document.createElement("Label");
                        label.setAttribute("for", it.facid);
                        label.setAttribute("class", "custom-control-label");
                        label.innerHTML = it.facname;

                        var newInput = document.getElementById(it.facid)
                        insertAfter(newInput, label);
                    }
                })
            })

        }

    }

    function removeOtherServCont() {
        var myobj = document.getElementById("otherServCont");
        if (myobj) {
            myobj.remove();
        }

        var newDiv = document.createElement("div");
        newDiv.setAttribute("id", "otherServCont");
        document.getElementById("mainOsc").appendChild(newDiv);
    }

    function getOtherServices(id) {

        mserv_cap.map((it) => {
            if (it.hgpid == id) {
                var newDiv = document.createElement("div");
                newDiv.setAttribute("class", "custom-control custom-radio mr-sm-2");
                newDiv.setAttribute("id", "otherServe-" + it.facid);
                document.getElementById("otherServCont").appendChild(newDiv);

                var x = document.createElement("INPUT");
                x.setAttribute("id", it.facid);
                x.setAttribute("onclick", "getFacServCharge()");
                x.setAttribute("type", "radio");
                x.setAttribute("value", it.facid);
                x.setAttribute("name", "facid");
                x.setAttribute("class", "custom-control-input os_list");
                document.getElementById("otherServe-" + it.facid).appendChild(x);

                var label = document.createElement("Label");
                label.setAttribute("for", it.facid);
                label.setAttribute("class", "custom-control-label");
                label.innerHTML = it.facname;

                var newInput = document.getElementById(it.facid)
                insertAfter(newInput, label);

            }
        })
    }

    function show_hosplevel_anx(selected, ancData, hgpid) {
       
        getFacServCharge()
  
        document.getElementsByClassName("addOnServe")[0].removeAttribute("hidden")
        document.getElementsByClassName("ancillary")[0].removeAttribute("hidden")
        if (selected == "H") {
            document.getElementsByClassName("hl1")[0].removeAttribute("hidden")
            getJospLevelServices(ancData, "H", hgpid);
            document.getElementsByClassName("hl2")[0].removeAttribute("hidden")
            getJospLevelServices(ancData, "H2", hgpid);
            document.getElementsByClassName("hl3")[0].removeAttribute("hidden")
            getJospLevelServices(ancData, "H3", hgpid);

           const inpt =  document.getElementById("anxservcontH").querySelectorAll('input[type="radio"]');
            for(var i = 0; i < inpt.length; i++){
               inpt[i].checked = true;
            }
           
            // getJospLevelServices(ancData);
        } else if (selected == "H2") {
            document.getElementsByClassName("hl1")[0].setAttribute("hidden", "hidden")
            document.getElementsByClassName("hl2")[0].removeAttribute("hidden")
            getJospLevelServices(ancData, "H2", hgpid);
            document.getElementsByClassName("hl3")[0].removeAttribute("hidden")
            getJospLevelServices(ancData, "H3", hgpid);
            // getJospLevelServices(ancData);
            const inpt =  document.getElementById("anxservcontH2").querySelectorAll('input[type="radio"]');
            for(var i = 0; i < inpt.length; i++){
               inpt[i].checked = true;
            }
        } else if (selected == "H3") {
            ifAmbuSurg("show")
            document.getElementsByClassName("hl1")[0].setAttribute("hidden", "hidden")
            document.getElementsByClassName("hl2")[0].setAttribute("hidden", "hidden")
            document.getElementsByClassName("hl3")[0].removeAttribute("hidden")
            getJospLevelServices(ancData, "H3", hgpid);
            // getJospLevelServices(ancData);

            const inpt =  document.getElementById("anxservcontH3").querySelectorAll('input[type="radio"]');
            const chk =  document.getElementById("anxservcontH3").querySelectorAll('input[type="checkbox"]');
            for(var i = 0; i < inpt.length; i++){
               inpt[i].checked = true;
            }
            for(var i = 0; i < chk.length; i++){
                chk[i].checked = true;
            }
        }
    }

    function getJospLevelServices (arr,selected, hgpid){
        

        var ar0 = arr[0].filter(function(v) {//get the services of hospital type
                return v.hgpid == 6;
        })

        var ar1 = arr[1].filter(function(v) {
                return v.facid == selected;//get the Id of selected hospital level
        })
        // console.log("ar1")
      
        
        var h1Facid = arr[1].filter(function(v) {//get the Id of hospital level1
                return v.facid == "H";
        })

        const duplicats = ar0.reduce((a, e) => {//find the Dupluicates of services groupname or remove the single group name
          a[e.grphrz_name] = ++a[e.grphrz_name] || 0;
         return a;
        }, {});

        var filtDups = ar0.filter(e => duplicats[e.grphrz_name])//get only the objects with duplicates
      
        var filtDupsArr = []

        var servs = filtDups.filter(function(v) {//filter the duplicates base on selected level
                filtDupsArr.push(v.grphrz_name) //store the groupname of duplicates
                return v.servtype_id == ar1[0].servtype_id;
        })

      
       

        filtDupsArr = [...new Set(filtDupsArr)] // jeust get single groupname remove pair of duplicates

     


        var special = ar0.filter(function( o){//remove all duplicates from all services, all single groupname must be stores here
        return filtDupsArr.indexOf(o.grphrz_name) == -1;
        });

      

       

        var specservs = special.filter(function(v) {
                return v.servtype_id == ar1[0].servtype_id;
        })
       
       
        var allH1GroupName =[]
        var h1gn = filtDups.filter(function(v) {//filter the duplicates base on selected level
                    if( v.servtype_id == h1Facid[0].servtype_id) { 
                    allH1GroupName.push(v.grphrz_name) //store the groupname of duplicates
                    }
                return v.servtype_id == h1Facid[0].servtype_id;
        })

      

        var h1mt = servs.filter(function( o){
        return allH1GroupName.indexOf(o.grphrz_name) >= 0;
        });
        

        var h1nmatch = servs.filter(function( o){
        return allH1GroupName.indexOf(o.grphrz_name) == -1;
        });
      

        var sortedh1nmatch = h1nmatch.sort(function (a, b) {
        return a.grphrz_name.localeCompare(b.grphrz_name);
         });

         var sortedh1mt = h1mt.sort(function (a, b) {
             return a.grphrz_name.localeCompare(b.grphrz_name);
         });
         

        document.getElementById("anxservcont"+selected).innerHTML = " ";
       var  asc =document.getElementById("anxservcont"+selected)
      
        if(asc != undefined || asc != null) {
            sortedh1mt.map((l1) => {
            createAnxRadio(l1,selected)
            })
         
            sortedh1nmatch.map((l2) => {
            createAnxRadio(l2,selected)
            })

        }

        if(specservs.length > 0){
            specservs.map((l1) => {
                createAnxCheckBox (l1,selected)
             })
            
        }

      
    }

    function createAnxRadio (l1, selected){
        var newDiv = document.createElement("div");
                newDiv.setAttribute("id", "asc-" + l1.facid);
                newDiv.setAttribute("class", "row custom-control custom-radio mr-sm-2");
                document.getElementById("anxservcont"+selected).appendChild(newDiv);

                var x = document.createElement("INPUT");
                x.setAttribute("id", l1.facid);
                x.setAttribute("onclick", "getFacServCharge()");
                x.setAttribute("type", "radio");
                x.setAttribute("value", l1.facid);
                x.setAttribute("name", l1.grphrz_name);
                x.setAttribute("class", "custom-control-input anxsel");
                document.getElementById("asc-" + l1.facid).appendChild(x);

                var label = document.createElement("Label");
                label.setAttribute("for", l1.facid);
                label.setAttribute("class", "custom-control-label");
                label.innerHTML = l1.facname;

                var newInput = document.getElementById(l1.facid)
                insertAfter(newInput, label);
    }

    function createAnxCheckBox (l1,selected){
        var newDiv = document.createElement("div");
                newDiv.setAttribute("id", "asc-" + l1.facid);
                newDiv.setAttribute("class", "row custom-control custom-radio mr-sm-2");
                document.getElementById("anxservcont"+selected).appendChild(newDiv);

                var x = document.createElement("INPUT");
                x.setAttribute("id", l1.facid);
                x.setAttribute("onclick", "getFacServCharge()");
                x.setAttribute("type", "checkbox");
                x.setAttribute("value", l1.facid);
                x.setAttribute("name", l1.grphrz_name);
                x.setAttribute("class", "custom-control-input anxsel");
                document.getElementById("asc-" + l1.facid).appendChild(x);

                var label = document.createElement("Label");
                label.setAttribute("for", l1.facid);
                label.setAttribute("class", "custom-control-label");
                label.innerHTML = l1.facname;

                var newInput = document.getElementById(l1.facid)
                insertAfter(newInput, label);
    }

    function getAncillary(selected, hgpid){
        let sArr = ['_token='+document.getElementsByName('_token')[0].value, 'facid[]=H', 'facid[]=H2', 'facid[]=H3'];
        let resp = []
        var nas;
        sendRequestRetArr(sArr, "{{asset('client1/request/customQuery/getGoAncillary')}}", "POST", true, {
					functionProcess: function(arr) {
                        show_hosplevel_anx(selected, arr, hgpid)
                    }
				});
       
    }
    function saveas(val){
        var itm = document.getElementById(val);
        itm.value = "final";
    }
    document.getElementById("buttonId").addEventListener("click", function(event) {
        event.preventDefault()
        var itm = document.getElementById("tr_amb");
        var cln = itm.cloneNode(true);
        cln.removeAttribute("id");
        cln.removeAttribute("hidden");
        cln.setAttribute("class", "tr_amb");
        document.getElementById("body_amb").appendChild(cln);
    });

    

    document.getElementById("buttonIdAos").addEventListener("click", function(event) {
        event.preventDefault()
        var itm = document.getElementById("tr_addOn");
        var cln = itm.cloneNode(true);
        cln.removeAttribute("id");
        cln.removeAttribute("hidden");
        cln.setAttribute("class", "tr_addOn");
        document.getElementById("body_addOn").appendChild(cln);
    });


    function preventDef() {
        event.preventDefault()
    }

    window.addEventListener('change', function(e) {
        if (e.target.id == 'ambtyp') {
            getChargesPerAmb();
        }

        if (e.target.name == 'facid') {
            // for updates just loop the data from database evrytime user changes fcid
            if (e.target.value == 'HDS') {
                document.getElementsByClassName("addOnServe")[0].removeAttribute("hidden")
            }
           

            if(e.target.className != "custom-control-input exAddRenew"){
            renewAddOnSelect(e.target.value)
            }
        }

        if(e.target.name == 'ocid'){
            setTimeout(function(){  
                   
                    getFacServCharge()
            }, 1000);
        }

        if(e.target.name == 'addOnServ'){
			
			if( $('input[name="hgpid"]:checked').val() == 5 ){
				document.getElementById("noDal").removeAttribute("hidden")
			}
            else if(e.target.value == 'H3ADC' ){
				document.getElementById("noDal").removeAttribute("hidden")
            }
            else{

                document.getElementById("noDal").setAttribute("hidden", "hidden")
                document.getElementById("noofdialysis").value = null;
            }
        }
        
    });

    function getNoDialysis(){
        var l3 = document.getElementById("H3ADC");

        if(document.getElementById("5").checked == true ){
            document.getElementById("noDal").removeAttribute("hidden")
        }else{

            document.getElementById("noDal").setAttribute("hidden", "hidden")
            document.getElementById("noofdialysis").value = null;
        }

        if(l3){
            if(l3.checked == true ){
            document.getElementById("noDal").removeAttribute("hidden")
            }else{
                document.getElementById("noDal").setAttribute("hidden", "hidden")
                document.getElementById("noofdialysis").value = null;
            }
        }
    }

 

    function renewAddOnSelect(id) {
        removeAddOnRows()
        $('.addOnServ').remove()
        $('#addOnServ').remove()

        var newAddOns = getAddonServices(id);

        var newSel = document.createElement("select");
        newSel.setAttribute("class", "form-control");
        newSel.setAttribute("id", "addOnServ");
        newSel.setAttribute("name", "addOnServ");
        document.getElementById("aoselCont").appendChild(newSel);


        newAddOns.map((h) => {
            if(h.facid != "H2-AO-DC" && h.facid != "H1-AO-DC"){
            var opt = document.createElement("option");
            opt.value = h.facid;
            opt.textContent = h.facname;
            document.getElementById("addOnServ").appendChild(opt);
            }
        });
    }

    function removeAddOnRows() {
        var aosObject = document.getElementsByClassName("tr_addOn");
        if (aosObject) {
            $('.tr_addOn').remove();
        }

    }

    function removeAmbuRows() {
        
        let serv_chg_not = document.getElementById('serv_chg_not');
            serv_chg_not.innerHTML = "";

        var amObject = document.getElementsByClassName("tr_amb");
        if (amObject) {
            $('.tr_amb').remove();
        }

    }


    function getAddonServices(theId) {
        let arrAddon = [];
        if (typeof(theId) !== 'undefined' && theId.length) {
            // let arrAddon = [];
            $.ajax({
						url: '{{asset('client1/request/customQuery/getAncillary')}}',
						dataType: "json", 
	    				async: false,
						method: 'POST',
						data: {_token:$("input[name=_token]").val(),id: theId, selected : theId, from: 1},
						success: function(a){
							arrAddon.push(JSON.parse(a));
                            
						}
					});
        }
        return arrAddon[0];
    }

    function getChargesPerAmb() {
        const subclass = $('#subclass').val()  == "" ||  $('#subclass').val() == undefined ? '{!!((count($fAddress) > 0) ? $fAddress[0]->subClassid: "")!!}' : $('#subclass').val();//appchargetemp

        var ta=[]; //appchargetemp


        var ambT1Ch = parseFloat(('{!!$ambcharges[0]->amt!!}'));
        var ambT2Ch = parseFloat(('{!!$ambcharges[1]->amt!!}'));
        let sArr = ['_token=' + document.getElementsByName('_token')[0].value, 'appid=' + curAppid],
        theuseless = [],
            ambtyp = document.getElementsByName('ambtyp'),
            plate_number = document.getElementsByName('plate_number'),
            ambOwner = document.getElementsByName('ambOwner'),
            amount = 0;
        if (ambtyp != null || ambtyp != undefined) {
            for (let i = 0; i < ambtyp.length; i++) {

                if (ambtyp[i].value == '1') {
                    plate_number[i].placeholder = "Number of Ambulance";
                    ambOwner[i].parentElement.removeAttribute('hidden');
                }
                if (ambtyp[i].value == '2') {
                    amount = amount + ((amount < 1) ? ambT1Ch + ambT2Ch :ambT1Ch );
                    plate_number[i].placeholder = "Plate Number/Conduction Sticker";
                    ambOwner[i].parentElement.setAttribute('hidden', true);
                    ambOwner[i].value = "";           
                }
            }
            if(amount > 0 ){
            let serv_chg_not = document.getElementById('serv_chg_not');
            serv_chg_not.innerHTML = "";
                   
            serv_chg_not.innerHTML += '<tr><td>' + "Ambulance Charge" + '</td><td>&#8369;&nbsp;<span>' + numberWithCommas(subclass == "ND" ? 0 :(parseInt(amount)).toFixed(2)) + '</span></td></tr>'
        }
            sArr.push('ambamt=' + amount);
        }


        sendRequestRetArr(sArr, "{{asset('client1/request/customQuery/getChargesPerAmb')}}", "POST", true, {
            functionProcess: function(arr) {
                for (let i = 0; i < arr.length; i++) {
                ta.push({reference : arr[i]['chg_desc'],amount: subclass == "ND" ? 0 : arr[i]['amt'], chgapp_id:  arr[i]['chgapp_id'] }) //appcharge
                }
                    document.getElementById('tempAppChargeAmb').value = JSON.stringify(ta)//appchargetemp
            }
        });
    }

//   INITIAL STATES
@if(app('request')->input('cont') == 'yes')

      var id =   '{!!((count($fAddress) > 0) ? $fAddress[0]->hgpid: "")!!}';
      document.getElementById('{!!((count($fAddress) > 0) ? $fAddress[0]->hgpid: "")!!}').checked = true
      var servFacArray =JSON.parse('{!!((count($fAddress) > 0) ? $servfac: "[]")!!}');

        setTimeout(function(){ 
            type_of_fac(id)
            if(id == 6){
                var func = '{!!((count($fAddress) > 0) ? $fAddress[0]->funcid: "")!!}';
            document.querySelector('select[data-funcid="duplicate"]').value = func;
            sel_hosp_class(func)

        
        }
        }, 2000);

        setTimeout(function(){ 
            var fc = servFacArray[1]
            
            document.getElementById(fc[0].facid).checked = true
            getAncillary(fc[0].facid, 6)
            
        }, 3000);

  var hg = document.getElementsByName('hgpid');

  for(var h = 0 ; h< hg.length; h++){
    hg[h].disabled = true;
  }
    
@endif

if('{!!isset($fAddress)&&(count($fAddress) > 0)!!}'){
    const base_url = '{{URL::to('/')}}';
    
    window.addEventListener('click', function(e) {
      
            if(document.getElementById("classification").value == ""){
            @if(app('request')->input('cont') == 'yes')
                if('{!!isset($fAddress)&&(count($fAddress) > 0)!!}'){
                    var ocid ='{!!((count($fAddress) > 0) ? $fAddress[0]->ocid: "")!!}';
                    var classid ='{!!((count($fAddress) > 0) ? $fAddress[0]->classid: "")!!}';

                    if(ocid){
                        setTimeout(function(){ 
                            fetchClassification1()
                        }, 1000);

                        setTimeout(function(){ 
                            document.getElementById("classification").value=classid;
                        }, 2000);
                        setTimeout(function(){ 
                            fetchSubClass1() }, 3000);

                        setTimeout(function(){ 
                            document.getElementById("subclass").value=subclassid;
                        }, 4000);
                    }
                }
            @endif
    }
    });

    var apptypenew = '{!! $apptypenew !!}';

    if(apptypenew == "renewal"){

    document.getElementById("aptidnew").value = 'R';
    document.getElementById("appid").value = null;
    document.getElementById("renewal").removeAttribute("hidden");

    }else{
    document.getElementById("appid").value = appid;
    }

   
    var areacode = JSON.parse('{!!((count($fAddress) > 0) ? $fAddress[0]->areacode: "")!!}');
    
    if(areacode.length > 0){
        
          var arc = areacode[0];
          var farc = areacode[1];
          var proparc = areacode[2];
          var arcode = document.getElementById('areacode');
          arcode.value = arc  
        
          var farcode = document.getElementById('faxareacode');
          farcode.value = farc   
          
          var propcode = document.getElementById('prop_landline_areacode');
          propcode.value = proparc 
    }

    
        var uid ='{!!((count($fAddress) > 0) ? $fAddress[0]->uid: "")!!}';
        var aptidnew ='{!!((count($fAddress) > 0) ? $fAddress[0]->aptid: "")!!}';
        var appid ='{!!((count($fAddress) > 0) ? $fAddress[0]->appid: "")!!}';
        var ocid ='{!!((count($fAddress) > 0) ? $fAddress[0]->ocid: "")!!}';
        var classid ='{!!((count($fAddress) > 0) ? $fAddress[0]->classid: "")!!}';
        var subclassid ='{!!((count($fAddress) > 0) ? $fAddress[0]->subClassid: "")!!}';
        var facmode ='{!!((count($fAddress) > 0) ? $fAddress[0]->facmode: "")!!}';
        var funcid ='{!!((count($fAddress) > 0) ? $fAddress[0]->funcid: "")!!}';
        var owner ="{!!((count($fAddress) > 0) ? $fAddress[0]->owner: '')!!}";
        // var owner ='{!!((count($fAddress) > 0) ? $fAddress[0]->owner: "")!!}';
        var ownerMobile ='{!!((count($fAddress) > 0) ? $fAddress[0]->ownerMobile: "")!!}';
        var ownerLandline ='{!!((count($fAddress) > 0) ? $fAddress[0]->ownerLandline: "")!!}';
        var ownerEmail ='{!!((count($fAddress) > 0) ? $fAddress[0]->ownerEmail: "")!!}';
        var mailingAddress ='{!!((count($fAddress) > 0) ? $fAddress[0]->mailingAddress: "")!!}';
        var approvingauthoritypos ='{!!((count($fAddress) > 0) ? $fAddress[0]->approvingauthoritypos: "")!!}';
        var approvingauthority ='{!!((count($fAddress) > 0) ? $fAddress[0]->approvingauthority: "")!!}';
        var ptcCode ='{!!((count($fAddress) > 0) ? $fAddress[0]->ptcCode: "")!!}';
        var noofbed ='{!!((count($fAddress) > 0) ? $fAddress[0]->noofbed: "")!!}';
        var noofmain ='{!!((count($fAddress) > 0) ? $fAddress[0]->noofmain: "")!!}';
        var noofsatellite ='{!!((count($fAddress) > 0) ? $fAddress[0]->noofsatellite: "")!!}';
        var hfep ='{!!((count($fAddress) > 0) ? $fAddress[0]->hfep_funded: "")!!}';

        var rgnid ='{!!((count($fAddress) > 0) ? $fAddress[0]->rgnid: "")!!}';
        var provid ='{!!((count($fAddress) > 0) ? $fAddress[0]->provid: "")!!}';
        var cmid ='{!!((count($fAddress) > 0) ? $fAddress[0]->cmid: "")!!}';
        var brgyid ='{!!((count($fAddress) > 0) ? $fAddress[0]->brgyid: "")!!}';
        var noofdialysis ='{!!((count($fAddress) > 0) ? $fAddress[0]->noofdialysis: "")!!}';
        var comments ='{!!((count($fAddress) > 0) ? $fAddress[0]->appComment: "")!!}';
        var hgpid_in ='{!!((count($fAddress) > 0) ? $fAddress[0]->hgpid: "")!!}';
        var ocidInpt = document.getElementById("ocid");
        ocidInpt.value = ocid;
            if(ocid){
                setTimeout(function(){  
                    fetchClassification1()
                }, 1000);
                setTimeout(function(){ 
                    document.getElementById("classification").value=classid;
                }, 2000);
                setTimeout(function(){ 
                    fetchSubClass1()
                }, 3000);
                setTimeout(function(){ 
                    document.getElementById("subclass").value=subclassid;
                }, 4000);
            }

const fetchClassification1 = async (e) => {
    const ocid = $("#ocid").val();
    if( ocid ) {
        const data = { 'ocid' : ocid }
        callApi('/api/classification/fetch', data, 'POST').then(classification => {
            $("#classification").empty();
            $("#classification").append(`<option value=''>Please select</option>`);
           
            @if(app('request')->input('cont') != 'yes')
               $("#classification").removeAttr('disabled');
            @endif

            classification.data.map(c => {
                $("#classification").append(`<option value='${c.classid}'>${c.classname}</option>`);
            })
        })
    }
    else {
        $("#classification").addAttr('disabled')
    }
}

const fetchSubClass1 = async (e) => {
    const ocido = $("#ocid").val();
    const classido = $("#classification").val();
    if(ocido ) {
        const data = { 'ocid' : ocid, 'classid' : classid }
        callApi('/api/classification/fetch', data, 'POST').then(classification => {
            $("#subclass").empty();
            $("#subclass").append(`<option value=''>Please select</option>`);

            @if(app('request')->input('cont') != 'yes')
              $("#subclass").removeAttr('disabled');
            @endif

            classification.data.map(c => {
                $("#subclass").append(`<option value='${c.classid}'>${c.classname}</option>`);
            })
        })
    }
    else {
        $("#subclass").addAttr('disabled')
    }
}
      document.getElementById("uid").value = uid;
      document.getElementById("appid").value = appid;

      document.getElementById("aptidnew").value = aptidnew;
      document.getElementById("facmode").value = facmode;
      document.getElementById("funcid").value = funcid;
      document.getElementById("owner").value = owner;
      document.getElementById("prop_mobile").value = ownerMobile;
      document.getElementById("prop_landline").value = ownerLandline;
      document.getElementById("prop_email").value = ownerEmail;
      document.getElementById("official_mail_address").value = mailingAddress;
      document.getElementById("approving_authority_pos").value = approvingauthoritypos;
      document.getElementById("approving_authority_name").value = approvingauthority;
      document.getElementById("ptcCode").value = ptcCode;
      document.getElementById("noofbed").value = noofbed;
      document.getElementById("noofmain").value = noofmain ? noofmain : (hgpid_in == 6 ? 1 : null);
      document.getElementById("noofsatellite").value = noofsatellite;
      document.getElementById("noofdialysis").value = noofdialysis;
      var cmmt =  document.getElementById("remarks")
        if(cmmt){
            cmmt.value = comments;
        }
        if(hfep === '0'){
        document.getElementById("hfep").checked = true;
        }
        
    var typeamb=[];
    var ambtyp=[];
    var plate_number =[];
    var ambOwner=[];
        
       @if(count($fAddress) > 0 && isset($fAddress[0]->typeamb))
         typeamb =JSON.parse('{!!((count($fAddress) > 0) ? $fAddress[0]->typeamb: "" )!!}');
         ambtyp =JSON.parse('{!!((count($fAddress) > 0) ? $fAddress[0]->ambtyp: "[]")!!}');
         plate_number =JSON.parse('{!!((count($fAddress) > 0) ? $fAddress[0]->plate_number: "[]")!!}');
         ambOwner =JSON.parse('{!!((count($fAddress) > 0) ? $fAddress[0]->ambOwner: "[]")!!}');
       @endif


        var addonDesc ='{!!((count($fAddress) > 0) ? $fAddress[0]->addonDesc: "[]")!!}';
        var addonDescArr = JSON.parse(addonDesc.length > 0? addonDesc : '[]');
        var servFacArray =JSON.parse('{!!((count($fAddress) > 0) ? $servfac: "[]")!!}');
                if(servFacArray[0].length > 0){
                                var getHGPID = servFacArray[0];
                                var dbhgpid = getHGPID[0].hgpid;
                                type_of_fac(dbhgpid) //display facilities

                                var funcid ='{!!((count($fAddress) > 0) ? $fAddress[0]->funcid: "[]")!!}';
                                var fniInpt = document.getElementsByName('funcid')
                                        for(var i =0; i < fniInpt.length ; i ++){
                                            fniInpt[i].value = funcid
                                        }

                                        var getFACID = servFacArray[1];
                                        var theFACID = getFACID[0].facid;
                                        // Get the add on
                                            renewAddOnSelect(theFACID)
                                            initialAddOns(addonDescArr)
                                      
                                        // Initial ambulance
                                        initialAmbulDetails(typeamb, ambtyp, plate_number, ambOwner)

                                        // check initial facids
                                        var getFacidField = document.getElementById(theFACID);
                                        if(getFacidField){
                                            document.getElementById(theFACID).checked= true
                                        }

                                        if(dbhgpid == 6){
                                            // display selected hosp class
                                            sel_hosp_class(funcid)

                                            if(funcid != 2){
                                            getAncillary(theFACID, 6)
                                        
                                            }
                                            setTimeout(function(){  
                                            if(getFACID.length > 0){
                                                getFACID.map((h) => {
                                                    var getFacidField = document.getElementById(h.facid);
                                                    if(getFacidField){
                                                        document.getElementById(h.facid).checked= true
                                                    }
                                                    
                                                });
                                            }
                                           
                                        }, 1000);

                                        }else if(dbhgpid == 1){

                                            if(getFACID.length > 0){
                                                getFACID.map((h) => {
                                                    var getFacidField = document.getElementById(h.facid);
                                                    if(getFacidField){
                                                        document.getElementById(h.facid).checked= true
                                                    }
                                                    
                                                });
                                            }
                                        }

                      }
        
        const data = { 'ocid' : ocid, 'classid' : classid }
        if(subclassid != ""){
        $.ajax({
						url: '{{asset('api/classification/fetch')}}',
						dataType: "json", 
	    				async: false,
						method: 'POST',
						data: data,
						success: function(a){
                            var result = a.filter(function(v) {
                                    return v.classid == subclassid;
                            })
                            document.getElementById("subclass").placeholder = result[0].classname;
                            
						}
					});
        }

      function initialAddOns(addonDesc){
                //    First array
            if(addonDesc.length > 0){
                var elemTr =   tr_addOn.getElementsByTagName('input');
                var nln0 =  document.getElementById("tr_addOn").querySelectorAll('#addOnServ');
                nln0[0].value = addonDesc[0].facid;

                var nlntyp0 =  document.getElementById("tr_addOn").querySelectorAll('#aoservtyp');
                nlntyp0[0].value = addonDesc[0].servtyp;

                var nlnowner0 =  document.getElementById("tr_addOn").querySelectorAll('#aoservOwner');
                nlnowner0[0].value = addonDesc[0].servowner;

                // Rest Array
                    for(var i = 1; i < addonDesc.length ; i++){
                        var trAdon =   document.getElementById("tr_addOn");
                        var cln = trAdon.cloneNode(true);
                        cln.removeAttribute("id");
                        cln.removeAttribute("hidden");
                        cln.setAttribute("id","addon"+addonDesc[i].facid );
                        cln.setAttribute("class", "tr_addOn");
                        document.getElementById("body_addOn").appendChild(cln);

                        
                        var nlnsr =  document.getElementById("addon"+addonDesc[i].facid).querySelectorAll('#addOnServ');
                            nlnsr[0].value = addonDesc[i].facid; 
                            
                        var nlntyp =  document.getElementById("addon"+addonDesc[i].facid).querySelectorAll('#aoservtyp');
                        nlntyp[0].value = addonDesc[i].servtyp;

                        var nlnowner =  document.getElementById("addon"+addonDesc[i].facid).querySelectorAll('#aoservOwner');
                        nlnowner[0].value = addonDesc[i].servowner;
                        // console.log(nln)
                    }
            }
      }

     function initialAmbulDetails(typeamb, ambtyp, plate_number, ambOwner){
        if(typeamb.length > 0){
            var nltypa =  document.getElementById("tr_amb" ).querySelectorAll('#typeamb');
            nltypa[0].value = typeamb[0];  
            
            var nlamntyp =  document.getElementById("tr_amb" ).querySelectorAll('#ambtyp');
            nlamntyp[0].value = ambtyp[0]; 

            var nlpn =  document.getElementById("tr_amb" ).querySelectorAll('#plate_number');
            nlpn[0].value = plate_number[0]; 

                                    var nlao =  document.getElementById("tr_amb" ).querySelectorAll('#ambOwner');
                                    var nlaodiv =  document.getElementById("tr_amb" ).querySelectorAll('#ambownerdiv');
                                    
                                    if(ambtyp[0] == 1){
                                        nlaodiv[0].removeAttribute('hidden')
                                        nlao[0].value = ambOwner[0]; 
                                    }
                                    
            for(var ta = 1; ta < typeamb.length ; ta++){
            
                                var trAdon =   document.getElementById("tr_amb");
                                var cln = trAdon.cloneNode(true);
                                cln.removeAttribute("id");
                                cln.removeAttribute("hidden");
                                cln.setAttribute("class", "tr_amb");
                                cln.className += cln.className ? " "+"amb"+ta : "amb"+ta
                                document.getElementById("body_amb").appendChild(cln);

                                var nltypa =  document.getElementsByClassName("amb"+ta )[0].querySelectorAll('#typeamb');
                                nltypa[0].value = typeamb[ta]; 

                                var nlamntyp =  document.getElementsByClassName("amb"+ta )[0].querySelectorAll('#ambtyp');
                                nlamntyp[0].value = ambtyp[ta]; 

                                var nlpn =  document.getElementsByClassName("amb"+ta )[0].querySelectorAll('#plate_number');
                                nlpn[0].value = plate_number[ta];  
                                
                     
                                    var nlao =  document.getElementsByClassName("amb"+ta )[0].querySelectorAll('#ambOwner');
                                    var nlaodiv =  document.getElementsByClassName("amb"+ta )[0].querySelectorAll('#ambownerdiv');
                                    if(ambtyp[ta] == 1){
                                        nlaodiv[0].removeAttribute('hidden')
                                        nlao[0].value = ambOwner[ta]; 
                                    }
               
            }
        }

     }

      //   Get Fees
 setTimeout(function(){  
      getFacServCharge(addonDesc.length > 0? 2 : null) ;
      getChargesPerApplication();
        // get amubulance charge
      getChargesPerAmb()
        if(getFACID.length > 0){
            getFACID.map((h) => {
                var getFacidField = document.getElementById(h.facid);
                if(getFacidField){
                    document.getElementById(h.facid).checked= true
                }
                
            });
        }
    }, 2000);
} 
//   INITIAL STATES

@if(app('request')->input('grplo') == 'rlo')
document.getElementById("ocid").setAttribute("disabled", "disabled")
document.getElementById("facmode").setAttribute("disabled", "disabled")
document.getElementById("funcid").setAttribute("disabled", "disabled")
setTimeout(function(){  
    document.getElementById("classification").setAttribute("disabled", "disabled")
    setTimeout(function(){ 
        document.getElementById("subclass").setAttribute("disabled", "disabled")
 }, 3000);

 }, 3000);
setTimeout(function(){  
 var ffc = document.getElementsByName("facid")
 var hhg = document.getElementsByName("hgpid")

 if(ffc){
     for(var fc = 0; fc < ffc.length; fc++){
         ffc[fc].disabled = true;
     }
 }

if(hhg){
     for(var hh = 0; hh < ffc.length; hh++){
        hhg[hh].disabled = true;
     }
 }
}, 3000);
@endif

</script>