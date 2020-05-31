function submitCode(){
		
		var data1 = {
			sourceCode: btoa($("#code").val()),
			input: btoa($("#input").val()),
			expectedOutput: btoa($("#expectedOutput").val()),
			language: "CPP",
			time : 2
		}

		var data = {};
		data['createSubmission'] = data1;
		
		$("#output").val("Loading......");
		
		$.post("api.php",data1,function(response){
			//$("#outputResponse").html(response);
			response = JSON.parse(response);
			
        	if(typeof response.error == 'undefined'){
     
        		if(response.status.status=="CE" || response.status.status=="RTE")$("#output").val(response.compileMessage);
        		else $("#output").val(atob(response.output));
        		
        		$("#outputResponse").html("Total Time: " + response.time + " s<br/>Status: " + response.status.description);
    		}
    		else $("#outputResponse").html(response.errorMsg);
    	});
	}
