<?php
?>

	<div id="create-course-box" class="popup-box cCourse-popup">
        <a href="#" class="close"><img src="image/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
		<div class="data">
          <form method="post" class="cCourse" action="">
                <fieldset class="textbox">
            	<label class="coursename">
               <!-- <span>Course name</span> -->
                <input id="course-name" name="coursename" required="required" value="" type="text" autocomplete="on" placeholder="Course Name"/>
                </label>
				<label class="Professor">
                <!--<span>Professor</span>	-->
                <input id="professor" list="professors" type="text" required="required" placeholder="Instructor"/>
                </label>
				<label class="department">
                <!-- <span>Department</span>	 -->
                <input id="department" list="departments" type="text" required="required" placeholder="Department"/>
                </label>
				<label class="Semester">
                <!-- <span>Semester</span> -->
                <input id="semester" name="semester" required="required" value="" type="text" placeholder="Semester"/>
                </label>
				<span>Course image</span>
					<lable class="pic" >
						<input  accept= "image/*" required="required" type="file" id="course-img" name='course-img' />
					</lable>
				<span></span>
					
					<button id = "create-course" class="normal-size-button button" type="submit" >Submit</button>
					<!-- hidden reset input -->
					<div class = "reset">
						<input id="cc-reset" type = "reset"/>
					</div>
				</fieldset>
				
				<fieldset class="textbox2">
					<lable class ="descript">
						<!-- <span>Description</span> -->
						<textarea  id = "course-description" cols="20" placeholder="Description"></textarea>
					</lable>
					
					<output id="imgout"></output>
					
					
                </fieldset>
          </form>
		</div>
	</div>


