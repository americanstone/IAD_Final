/*Author: Guojun Zhang
 *Filename: myCourse.js
 *Purpose: When click the course button on top menue
 *         ajax fetch chosen course base user role and name.  
 *         it will alowed display the content w/o direct the page
 *Call: by          
 *
 */

$(document).ready(function(){
	
//	$("a#course").click(function(event){
//            event.preventDefault();
//
//            $("ul#menues li a").removeClass("selected-menue");
//            $(this).addClass("selected-menue");
   
                    //remove everything under div 'content'
                    $(".content").empty();
                    //add two div within the div 'content'
                    $(".content").append("<div id ='my-courses'></div>");
                    $(".content").append("<div id ='all-courses'></div>");
                    //fetch my enrolled courses		
                    fetchMyCourses();

                    //fetch all courses information
                    fetchAllCourses();

                    //append a Create course button
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function (){
                        if(xhr.readyState == 4 && xhr.status == 200){
                            var result = xhr.responseText;
                            if(result == "true"){
                                appendButton();
                            }
                         };
                    };
                    //have to be false, in order that binding the event
                    xhr.open("POST","server/_getProfessor.php?action=verify",false );
                    xhr.send(null);
                    /*
                      var jqXHR = $.ajax({
                            url: "server/getProfessor.php",
                            data: {action: "verify"},
                            dataType: "text",
                            success: function(data){
                               
                            }
                        });
                        alert(jqXHR.responseText);
                        
                    if(jqXHR.responseText == "true"){
                         appendButton();
                    }
                   */
		
	    // pop up create course box when 'Create Course' is clicked
            $('a.create-course-window').click(function() {

                    //Getting the variable's value from a link 
                    var coursebox = $(this).attr('href');

                    //Fade in the Popup
                    $(coursebox).fadeIn(300);

                    //Set the center alignment padding + border see css style
                    var popMargTop = ($(coursebox).height() + 24) /2; 
                    var popMargLeft = ($(coursebox).width() + 24) / 2; 

                    $(coursebox).css({ 
                            'margin-top' : -popMargTop,
                            'margin-left' : -popMargLeft
                    });

                    // Add the mask to body
                    //mask css define in popup.css
                    $('body').append('<div id="mask"></div>');
                    $('#mask').fadeIn(300);

                    //ajax fetch Professor list and append as option list
                    fetchProfessor()

                    return false;
            });
			
	
	
            // When clicking on the button close or the mask layer the popup closed
            //Attach an event handler for all elements which match the current selector, now and in the future.
            $('a.close').live('click', function() { 
                    $('#cc-reset').trigger('click');
                    $('#mask , .cCourse-popup').fadeOut(300 , function() {
                        //remove the element itself
                            $('#mask').remove();  
                    }); 

                    /* may add function update the all course slideshow */
                    //constructAllCourse("course");

                    return false;
            });
			
			
            //HTML5 file api read file content from local filesystem and display the image
            $('#course-img').change(function(event){

                var files = event.target.files; // FileList object

                // Loop through the FileList and render image files as thumbnails.
                for (var i = 0, f; f = files[i]; i++) {

                    // Only process image files. this part can be process by html arrt "accept"
                    /*
                    if (!f.type.match('image.*')) {
                    continue;
                    }*/

                    var reader = new FileReader();

                    // Closure to capture the file information.
                    reader.onload = (function(theFile) {
                    return function(e) {
                    // Render thumbnail.
                    var span = document.createElement('span');
                    span.innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                    document.getElementById('imgout').insertBefore(span, null);
                    };
                    })(f);
                    $(".thumb").addClass("thumb");
                    // Read in the image file as a data URL.
                    reader.readAsDataURL(f);
                }
            });
            
            /** add a new course  */
            $('#create-course').click(function(event) {
                event.preventDefault();
                var file = document.getElementById('course-img').files[0];
                var fd = new FormData();
                fd.append('upload_file', file);
                fd.append('action', "add");
                fd.append('title', $('#course-name').val());
                fd.append('description', $('#course-description').val());
                fd.append('instructor', $('#professor').val());
                fd.append('department', $('#department').val()); 
                fd.append('semester', $('#semester').val());
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if(xhr.readyState == 4){
                        if(xhr.status == 200) {
                            var message = xhr.responseText;
                            if(message == "true"){
                                //close the create course pop up box
                                $('a.close').trigger('click');
                                //refresh the course page to show the new added course
                                 window.location.reload();
                            }
                        }
                    }
                };
                xhr.open('POST', 'server/_course.php', true);
                xhr.send(fd);
	});

});

//when current session is admin, adding create course button 
function appendButton(){
	$(".subtitle:first").append("<a href='#create-course-box' class='create-course-window'>Create Course</a> ");
	
}
//ajax fetch instructor list 
function fetchProfessor(){
	$.ajax({
                url: "server/_getProfessor.php",
                data: {action: "list"},
                dataType: "xml",
                success: function(data){
                        console.log(data);
                        var thtml = "<datalist id='professors'>";

                        $(data).find("name").each(function(){
                                var value = $(this).text();
                                thtml += "<option value='"+ value + "'/>";
                        });
                        thtml += "</datalist>";

                        $("#professor").after(thtml);
                }
	});
}

function fetchMyCourses(){

	$.ajax({
		url: "server/_course.php",
		data: {action: "mycourses"},
		dataType: "xml",
		async: false,
		success: function(data){
                    var thtml = "<div class='subtitle'><h2>My Courses</h2></div>";
                    thtml += "<div id = 'my-courses-row-container'>";

                    $(data).find("mycourse").each(function(){
                            var img = "http://localhost/sbls/";
                            img = img + $(this).find("course_img").text();			

                            thtml = thtml + "<div >";
                            thtml = thtml + "<table id = 'my-courses-row' align='center' width='100%' cellpadding='30px'>";
                            thtml = thtml + "<tr><td width='30%'><div id = 'my-course-img'><img class = 'small-size-image' src= '" + img + "'/></div></td>";

                            thtml = thtml + "<td width='35%'><div id = 'my-course-text'><a href='course.php?course="+$(this).find("course_id").text()+"'><h3>" + $(this).find("title").text() + "<br/></h3></a>";
                            thtml = thtml + "" + $(this).find("department").text();
                            thtml = thtml + "   " + $(this).find("semester").text() + "<br/>";
                            thtml = thtml + "Instructor: " + $(this).find("instructor").text() + "<br/>";
                            thtml = thtml + "My Role: " + $(this).find("role").text() + "   ";
                            thtml = thtml + "<a href=''>" + $(this).find("group_name").text() + "</a></div></td>"

                            thtml = thtml + "<td width='20%'><div id = 'my-course-button'>";
                            thtml = thtml + "<form action='server/_course.php?action=unenroll&course=" + $(this).find("course_id").text()+ "' method='POST'>"
                            thtml = thtml + "<input type='submit' class = 'normal-size-button' name='unenroll-course' value='Unenroll'/>";
                            thtml = thtml + "</form>"
                            thtml = thtml + "</div></td>";
                            thtml = thtml + "</div>";

                            });
                    thtml += "</div>";
                    $("#my-courses").html(thtml);
		}
	}); 
}

function fetchAllCourses(){
	$.ajax({
                url: "server/_course.php",
                data: {action: "list"},
                dataType: "xml",
                async: false,
                success: function(data){
                        var thtml = "<div class='subtitle'><h2>All Courses</h2></div>";
                        thtml = thtml + "<div id='slideshow'><div id='slidesContainer'>"
                        $(data).find("course").each(function(){
                                var img = "http://localhost/sbls/";
                                img = img + $(this).find("course_img").text();

                                var text = '<a href="course.php?course='+$(this).find("course_id").text()+'"><h3>' + $(this).find("title").text() + "</h3></a>";
                                text += $(this).find("department").text() + "  ";
                                text += $(this).find("semester").text() + "<br/>";
                                text += "Instructor: " + $(this).find("instructor").text();

                                thtml = thtml + " <div class='slide'><div class='all-courses-img'><img src= '" + img + "'/></div>";
                                thtml = thtml + "<div class='all-courses-text'>" + text + "</div>";
                                thtml = thtml + "</div>";

                        });
                        thtml = thtml + "</div></div>";
                        $("#all-courses").html(thtml);

                        var currentPosition = 0;
                        var slideWidth = 240;
                        var slides = $('.slide');
                        var numberOfSlides = slides.length;

                        // Remove scrollbar in JS
                        $('#slidesContainer').css('overflow', 'hidden');

                        // Wrap all .slides with #slideInner div
                        slides
                                .wrapAll('<div id="slideInner"></div>')
                                // Float left to display horizontally, readjust .slides width
                                .css({
                                'float' : 'left',
                                'width' : slideWidth
                                });

                        // Set #slideInner width equal to total width of all slides
                        $('#slideInner').css('width', slideWidth * numberOfSlides);

                        // Insert controls in the DOM
                        $('#slideshow')
                                .prepend('<span class="control" id="leftControl">Clicking moves left</span>')
                                .append('<span class="control" id="rightControl">Clicking moves right</span>');

                            // Hide left arrow control on first load
                             manageControls(currentPosition);

                        // Create event listeners for .controls clicks
                        $('.control')
                            .bind('click', function(){
                            // Determine new position
                            currentPosition = ($(this).attr('id')=='rightControl') ? currentPosition+1 : currentPosition-1;

                            // Hide / show controls
                            manageControls(currentPosition);
                            // Move slideInner using margin-left
                            $('#slideInner').animate({
                            'marginLeft' : (slideWidth+5)*(-currentPosition)
                            });
                        });

                        // manageControls: Hides and Shows controls depending on currentPosition
                        function manageControls(position){
                            // Hide left arrow if position is first slide
                            if(position==0){ $('#leftControl').hide() } else{ $('#leftControl').show() }
                            // Hide right arrow if the last slide is shown
                            if(position==numberOfSlides-5){ $('#rightControl').hide() } else{ $('#rightControl').show() }
                        }

                }
	}); 
}