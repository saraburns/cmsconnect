	Begin modal contents -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="Create Group" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Create Group</h4>
      </div>
      <div class="modal-body">
      	<div id="group_form">			
        <form method="post" id = "cg" action="<?php $_SERVER['PHP_SELF'] ?>">
      		<!-- first screen of modal form, loaded automatically, others loaded via AJAX -->
      		<div id ="choose_members">
      			<?php
        			require_once("choose-members.php");

        		?>
        	</div>
        	<!-- second screen of modal form -->
        	<div id ="choose_piece">
        	</div>
        	<!-- third screen of modal form -->
        	<div id = "choose_rehearse"></div>
			<!-- hidden inputs allow for more flexible form interaction -->        
        	<input type="hidden" name = "new_coach"></input>
        	<input type="hidden" name = "new_members"></input>
        	<input type="hidden" name = "new_coaching_time"></input>
        	<input type="hidden" name = "new_pid"></input>
        	<input type="hidden" name = "new_rehearsal"></input>


        </form> </div>
        	<!-- part of a mild form of form verification -->
        	<label id="error">Please select a time to rehearse and try again</label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="redo" data-dismiss="modal">Start Over</button>
        <button type="button" class="btn btn-primary" id= "add" name="add">Choose Piece</button>
      </div>
    </div>
  </div>
</div>

<script>
  $("#choose_piece").hide();
  $('#myModal').modal({show:false}).on('shown.bs.modal', function () {
  $('#myInput').focus()
});

  var current_members = [];
  var instruments = [];
  var coach = "";
  var coachID = "";
  var cTime = "";
  var coachAdded = false;
  var cTimeAdded = false;
  //three text states for the submit button
  var addButtons = ["Choose Piece", "Choose Rehearsal Time", "Create Group"];
  $(".select-time").selectable({
    	stop: function(){
    		$(".ui-selected", this).each(function(){
    			var timeslot = $(this).parent().attr("id");
    			console.log($(".select-time").parent().not("#" + timeslot));
    			//panels that don't contain that time slot are disabled(can be reenabled when a time is unselected)
				$(this).closest(".panel-group").children().filter(function(){
				return $(this).find("#" + timeslot).length == 0}).find("a").attr("data-toggle", "").css("color", "#828282");
				//record who is currently selected as part of this group/when the coaching time is, and display it
				if(!coachAdded){//the coach is the person in the outer panel list, the members are in the inner panel list
					coach = $(this).closest(".panel-group").closest(".panel").find("a").first().text().trim();
				 	$("#coach").append("<span class ='current_labels'>" + coach);
				 	coachID = $(this).closest(".panel-group").closest(".panel").find(".coach_name").attr("id");
				 	coachAdded = true;
				}
				var new_member = $(this).closest(".panel").find(".member_name").text();
				var member_id = $(this).closest(".panel").find(".member_name").attr("id");
				var instrument = $(this).closest(".panel").find(".instrument").text().trim();
				if(current_members.indexOf(member_id) < 0){
					current_members.push(member_id); 
					$("#members").append("<span class ='current_labels " + member_id + "'>" + new_member+"</span> ");
					instruments.push(instrument);
				}
				if(!cTimeAdded){
					cTime = $(this).parent().attr("id").trim();
					$("#ctime").append("<span class ='current_labels " + cTime + "'>" + $(this).text());
					cTimeAdded = true;
				}


    		});

    	}
    	//currently not functional - would like to be able to remove people from group on click as well
    // 	unselected: function(){
    // 		$(".ui-selectee",this).each(function(){
    // 		var timeslot = $(this).parent().attr("id");
    // 		$(this).closest(".panel-group").children().filter(function(){
				// return $(this).find("#" + timeslot).length == 0}).find("a").attr("data-toggle", "collapse").css("color", "#8ba9fe");
    // 		if(coachAdded && coach == $(this).closest(".panel-group").closest(".panel").find("a").first().text().trim()){
    // 			coach = "";
    // 			$("#coach").text("Coach: ");
    // 			coachAdded = false;
    // 		}

    // 			var mid = $(this).closest(".panel").find(".member_name").attr("id");
    // 			current_members.remove(current_members.indexOf(mid));
    // 			instruments.remove(instruments.indexOf($(this).closest(".panel").find(".instrument").text().trim()));
    // 			$(".current_labels " + mid).remove();
    // 		if(cTimeAdded){
    // 			var ct = timeslot.trim();
    // 			var text = ".current_labels " + ct;
    // 			if($(text).text() == $(this).text()){
    // 			$(text).remove();
    // 			cTimeAdded = false;
    // 		}

    // 		}


    		
    	// });
    // }


    });


 $("#error").hide();

  $("#add").on('click', function(event){
  	//these if statements determine what stage of group creation we're on
  	if($(this).text() == addButtons[0]){
  	$("#error").hide();
  	//mild form verification(don't need a lot since no user submitted data)
  	if(coach == "" || cTime == "" || members.length == 0){
  		$("#error").show();
  		return false;
  	}else{
  	//set necessary form inputs from current screen and move to next stage
  	$("input[name='new_coach']").val(coachID);
  	$("input[name='new_members']").val(current_members.join(";"));
  	$("input[name='new_coaching_time']").val(cTime);
  	// var inputString = "coach=" + coach + "&members=" + current_members.join(';') + "&cTime=" + cTime;
  	$.post("choose-piece.php", {"instruments": instruments.join(";")}, function(response){$("#choose_piece").html(response);$(".select-piece").selectable();});
  	$("#choose_members").hide();
  	$("#choose_piece").show();
  	$("#add").text(addButtons[1]);
  	  }

  	}else if($(this).text() == addButtons[1]){
  		//move onto the third stage
  		$("input[name='new_pid']").val($("input[name='options']:checked").attr("id"));
  		$("#add").text(addButtons[2]);
  		console.log($("#add").text());
  		//modal body is populated with html produced by choose-rehearse
  		$.post("choose-rehearse.php", {"members": current_members.join(";"), "coaching_time": cTime}, function(response){$("#choose_rehearse").html(response);});
  		 $("#choose_piece").hide();
  		 $("#choose_rehearse").show();
  	
   	}else if($(this).text() == addButtons[2]){
   		//time to submit, make sure to save the last form input
   		$("input[name='rehearsal']").val($("input[name='roptions']:checked").attr("id"));
		$("#cg").trigger("submit");
		 startOver();
   	}

  });
  

  //resets the modal and form to their initials states
  function startOver(){
  	$(".modal").find(".ui-selected").removeClass("ui-selected");
  	//reset the variables which hold the form input
  	coach = "";
  	current_members = [];
  	cTime = "";
  	cTimeAdded=false;
  	coachAdded=false;
	instruments = [];
	//reset the labels and go back to the first screen
  	$(".current_labels").remove();
  	$("#choose_piece,#choose_rehearse").hide();
  	$("input[type='hidden']").val("");
  	$("#choose_members").show();
  	$("#add").text(addButtons[0]);
  }

  $('#redo').on("click", function(){
  	startOver();
  })
</script>
