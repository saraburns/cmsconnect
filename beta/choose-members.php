<?php
/*choose-members.php
Displays an interface where students are displayed with coaches with whom they have common free time */
	echo "<p>Make a group and schedule coaching.<h5>Create a group and choose a coaching time. Click on a coach to see students with compatible times for coaching. Then, when a student is selected, the list will be
	filtered to include only students who have compatible times for both coaching and rehearsal.";

	//creates a collapsible panel list when given panel html and an index to distinguish it from other panels
	function collapsiblePanelList($ps,$index){
		return"<div class='panel-group' id='accordion$index' role='tablist' aria-multiselectable='true'>$ps</div>";
	}


	//returns a list panel given a title and content, as well as index information to associate it correctly
	function buildListPanel($title, $listelements, $index, $accordion_index){
	 return "<div class='panel panel-default'>
    <div class='panel-heading' role='tab' id='heading$index'>
      <h4 class='panel-title'>
        <a data-toggle='collapse' data-parent='#accordion$accordion_index' href='#collapse$index' aria-expanded='true' aria-controls='collapse$index'>
          $title
        </a>
      </h4>
    </div>
    <div id='collapse$index' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='heading$index'>
      <ul class='list-group'>
      $listelements
      </ul>
    </div>
  </div>";
	}

	
	//creates an html string from an array of ids and pretty times
	function tohtml_list($id_array, $time_array){
		$html_list = "";
		for($i=0; $i<count($id_array); $i++){
			$tid = $id_array[$i];
			$time = $time_array[$i];
			$html_list = $html_list."<li class='list-group-item select-time $tid' id=$tid><small>$time</small></li>";
		}

		return $html_list;
		

	}


	//finds students who have matching free time and displays them in a collapsible panel under the coach
	function findCompatibleCoach($cid){
		global $dbh,$panel_i, $accordion_i;
		$students = array();
		$compatible = "select s2.bnumber, s2.timeid from schedule, schedule as s2 where (schedule.bnumber = ? 
			and schedule.bnumber <> s2.bnumber and schedule.timeid = s2.timeid and s2.bnumber
			 in (select bnumber from humans where status='student' and ingroup=0))";
		$coach_compatibles = prepared_query($dbh,$compatible,array($cid));
		$list_items = "";
		while($compatible_result = $coach_compatibles->fetchRow(MDB2_FETCHMODE_ASSOC)){
			$id = $compatible_result['bnumber'];
			if(isset($students[$id])){
					array_push($students[$id]["times"],$compatible_result['timeid']);
			}else{
				$students[$id] = array();
				$student_lookup = "select * from humans where bnumber = ?";
				$lookup_result = prepared_query($dbh,$student_lookup, array($id));
				$students[$id]["times"] = array($compatible_result['timeid']);
				while($student_result = $lookup_result->fetchRow(MDB2_FETCHMODE_ASSOC)){
					$students[$id]['identifier'] = $student_result['identifier'];
					$students[$id]['instrument'] = $student_result['instrument'];
				}

			}
				//  <li class='list-group-item select-student' id='$id'><small>$identifier</small>
				// <span class='badge'>$instrument</span></li>";

			}
		//information about the students is collected into an associative array, and then the html is displayed at once(to prevent duplicates)	
		foreach($students as $bnumber=>$info){
			$instrument = $info['instrument'];
			$identifier = $info['identifier'];
			$times = $info['times'];
			$list_items = $list_items.buildListPanel("<div class='member_name' id='".$bnumber."''>".$identifier."</div><span class='badge instrument'>$instrument</span>",
				 tohtml_list($times, makePretty($times)), $panel_i++, $accordion_i);
		}
		return collapsiblePanelList($list_items, $accordion_i++);

	}
	
	$coaches_query = "SELECT identifier, bnumber from humans where status='coach'";
	$coach_result = query($dbh, $coaches_query);
	$panels = "";

	$panel_i= 0;
	$accordion_i = 0;
	//find compatible students for each coach and display them
	while($coach_row = $coach_result->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$coach_name = $coach_row["identifier"];
		$coach_id = $coach_row["bnumber"];
		$panels = $panels.(buildListPanel("<div class='coach_name' id='$coach_id'>$coach_name</div>", findCompatibleCoach($coach_id), $panel_i, $accordion_i++));
		$panel_i+= 1;
	}
	echo "<div id ='current_group'><br><span id='coach'> Coach: </span><br><span id = 'members'>Members: </span><br>
	<span id='ctime'>Coaching Time: </span></div><br>";
	echo collapsiblePanelList($panels, $accordion_i);
	?>