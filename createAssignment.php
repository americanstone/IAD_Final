<?php
?>

<div id="create-assignment-box" class="popup-box">
    <a href="#" class="close"><img src="image/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
	<div class="data">
        <form method="post" class="cAssign">
            <fieldset class="textbox">
				
				<!-- Assignment Name -->
            	<label class="assignname">
                <span>Assignment Name</span>
                <input id="assign-name" name="assign-name" required="required" value="" type="text" autocomplete="on"/>
                </label>
				<label class="duedate">
                <span>Due Date</span>	
                <input id="duedate" list="duedate" type="date" required="required" />
                </label>
				
				<!-- submit type -->
				<label class="submittype">
                                    <span>Submit Type</span>
                                        <!--
                                        <input id="submittype" required="required" type= "text" list = "submittype" />
                                        -->
                                    <select id="submittype">
                                        <option value="Group">Group</option> 
                                        <option value="Individual">Individual</option>
                                    </select>
				</label>
				
				<!-- Attachment -->				
				<lable class="attachment" >
				<span>Attachment</span>
					<input type="file" id="attachment" name='attachment' />
				</lable>
				
				<!-- submit buttom -->			
				<button id = "create-assignment" class="normal-size-button button" type="submit">Submit</button>
				
				<!-- hidden reset input -->
				<div class = "reset">
					<input id="ca-reset" type = "reset"/>
				</div>
			</fieldset>
				
			<fieldset class="textbox2">
				<lable class ="instruction">
					<span>Instruction</span>
					<textarea  id = "assign-instruction" required="required" cols="20" rows = "50"></textarea>
				</lable>				
            </fieldset>
        </form>
	</div>
</div>


