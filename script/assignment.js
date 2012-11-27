$(document).ready(function(){

       // $(".content").append("<div id ='my-assignment'></div>");

        //fetchMyAssignments();
        //popup assignment instruction
        $("a.assignment-instruction-window").on("click",function(event) {

                var assignID = $(this).attr('assign_id');
                var courseID = $('.content').attr("course-id");

                //query the detailed information of the specified assignment
                $.ajax({
                        url: "server/_assignment.php",
                        data: {action: "list", course_id: courseID, assign_id: assignID},
                        dataType: "xml",
                        async: false,
                        success: function(data){
                                var thtml = "<table style='text-align: left'>";
                                thtml += "<tr><th>Assignment</th><td>" + $(data).find("name").text() + "</td></tr>";
                                thtml += "<tr><th>Assigned Date</th><td>" + $(data).find("assign_date").text() + "</td></tr>";
                                thtml += "<tr><th>Due Date</th><td>" + $(data).find("due_date").text() + "</td></tr>";
                                thtml += "<tr><th>Submission Type</th><td>" + $(data).find("submit_type").text() + "</td></tr>";
                                thtml += "<tr><th>Instruction</th><td>" + $(data).find("instruction").text() + "</td></tr>";
                                var attachment = $(data).find("attachment").text();
                                var attachment_path = "http://localhost/sbls" + attachment;
                                thtml += "<tr><th>Attachment</th><td><a href='" + attachment_path + "' target='_blank'>" + attachment + "</td></tr>";
                                thtml += "</table>";
                                $('#instruction-data').html(thtml);
                        }

                });

                //Getting the variable's value from a link 
                var popupbox = $(this).attr('href');

                //Fade in the Popup
                $(popupbox).fadeIn(300);

                //Set the center alignment padding + border see css style
                var popMargTop = ($(popupbox).height() + 24) /2; 
                var popMargLeft = ($(popupbox).width() + 24) / 2; 

                $(popupbox).css({ 
                        'margin-top' : -popMargTop,
                        'margin-left' : -popMargLeft
                });

                // Add the mask to body
                $('body').append('<div id="mask"></div>');
                $('#mask').fadeIn(300);
                return false;
        });

        // pop up create assignment box
        var course_id;
        $('a.create-assignment-window').click(function(){
                course_id = $('.content').attr("course-id");

                //Getting the variable's value from a link 
                var popupbox = $(this).attr('href');

                //Fade in the Popup
                $(popupbox).fadeIn(300);

                //Set the center alignment padding + border see css style
                var popMargTop = ($(popupbox).height() + 24) /2; 
                var popMargLeft = ($(popupbox).width() + 24) / 2; 

                $(popupbox).css({ 
                        'margin-top' : -popMargTop,
                        'margin-left' : -popMargLeft
                });

                // Add the mask to body
                $('body').append('<div id="mask"></div>');
                $('#mask').fadeIn(300);
                return false;
        });

        // When clicking on the button close or the mask layer the popup closed
        $('a.close').live('click', function() { 
                $('#ca-reset').trigger('click');
                $('#mask , .popup-box').fadeOut(300 , function() {
                        $('#mask').remove();  
                }); 

                return false;
        });




// add a new assignment in server	
$('#create-assignment').on("click", function(event){
    if($('#assign-name').val() &&
         $('#duedate').val() &&
         $('#submittype').val() &&
         $('#assign-instruction').val() ){
        
        event.preventDefault();

        var file = document.getElementById('attachment').files[0];
        var fd = new FormData();
        fd.append('action', 'add');
        fd.append('attachment', file);
        fd.append('course_id', course_id);
        fd.append('assignment_name', $('#assign-name').val());
        fd.append('instruction', $('#assign-instruction').val());
        fd.append('due_date', $('#duedate').val());
        fd.append('submit_type', $('#submittype').val());

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
                if(xhr.readyState == 4){
                        if(xhr.status == 200) {
                                var message = xhr.responseText;
                               alert(message);
                                if(message == "true"){
                                   
                                        //close the create course pop up box
                                        $('a.close').trigger('click');
                                        //refresh the course page to show the new added course
                                        window.location.reload();
                                }
                        }
                }
        }
        xhr.open('POST', 'server/_assignment.php', true);
        xhr.send(fd);
        }
    });	


});

// fetch the assignment information for the courses I enrolled
function fetchMyAssignments(){
	
	$.ajax({
		url: "server/_assignment.php",
		data: {action: "myassignment"},
		dataType: "xml",
		async: false,
		success: function(data){
			
			var thtml = "";
			//create a table for every enrolled course
			$(data).find("course").each(function() {
				course_id = $(this).attr("id");
				my_role = $(this).attr("myrole");
				thtml += "<div class = 'bordered-box'>";
				thtml += "<div class = 'subtitle'><h2>" + $(this).attr("title") + "</h2>";
				if(my_role =="Instructor"){
					thtml += "<a href='#create-assignment-box' class='create-assignment-window' course_id = '" + course_id + "'>Create Assignment</a> ";
				}
				thtml += "</div>";
				thtml += "<table class='assignment-table'>";
				thtml += "<tr><th>Assignment</th><th>Name</th><th>Assign Date</th><th>Due Date</th><th>Score</th><th>Submission</th><tr>";
				
				//add a row for each assignment
				var background = true;
				$(this).find("assignment").each(function() {
					
					if(background){
						thtml += "<tr style='background-color: #F5F5F5'>";
					} else {
						thtml += "<tr>";
					}
					assign_id = $(this).find("assign_id").text();
					thtml += "<td class = 'width-80px-column'><a class = 'assignment-instruction-window' href='#assignment-instruction' course_id = '" + course_id + "'>" + assign_id + "</a></td>";
					thtml += "<td class = 'width-200px-column'>" + $(this).find("assign_name").text() + "</td>";
					thtml += "<td class = 'width-80px-column'>" + $(this).find("assign_date").text() + "</td>";
					thtml += "<td class = 'width-80px-column'>" + $(this).find("due_date").text() + "</td>";
					thtml += "<td class = 'width-80px-column'>" + $(this).find("score").text() + "</td>";
					thtml += "<td class = 'width-80px-column' course_id = '" + course_id + "' assign_id = '" + assign_id + "'><a id = 'submission-id' href = 'submission.php'>" + $(this).find("submission_id").text() + "</a></td>";
					thtml += "</tr>";
					background = !background;
				});
				thtml += "</table></div>";
				
			});
			
			$("#my-assignment").html(thtml);
			
		}
	});
}





