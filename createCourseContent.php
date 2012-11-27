<?php
//add redirect if not valid user
?>

	<div id="create-course-box" class="popup-box cCourse-popup">
        <a href="#" class="close"><img src="image/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
		<div class="data">
          <form method="post" class="cCourse" action="">
                <fieldset class="textbox">
                    <label class="coursename">
                    <!-- <span>Course name</span> -->
                    <input id="course-content" name="Topic" required="required" value="" type="text" autocomplete="on" placeholder="Topic"/>
                    </label>
                    
                    <span>Course attachment</span>
                            <lable class="pic" >
                                    <input  required="requirred" type="file" id="course-attachment" name='course-img' />
                            </lable>
                    <span></span>
                    
                    
                    <input id = "create-course-content" class="normal-size-button button" type="submit" name="Submit"/>
                    <!-- hidden reset input -->
                    <div class = "reset">
                            <input id="cc-reset" type = "reset"/>
                    </div>
                </fieldset>

                <fieldset class="textbox2">
                    <lable class ="descript">
                            <!-- <span>Description</span> -->
                            <textarea  id = "course-content-description" cols="20" required="requirred" placeholder="Description"></textarea>
                    </lable>

                   

                </fieldset>
          </form>
		</div>
	</div>


