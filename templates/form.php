<?php
/**
	 * The form template file 
	 *
	 * Harrison DeStefano
	 * harrison.destefano@gmail.com
	 *
	 * This is the form template file that that displays the form.
	 * Without this file all would be lost.
	 *
	 */
?>		

	<form>
    	<div class="card">
	        <div class="ribbon-wrapper">
            	<div class="ribbon">
                	FORK ME
				</div>
			</div>
	        <div class="card-image">
        		<img src="../images/comic.png" alt="comic" width="523" height="252" />
			</div>
			<div class="card-header">
	            XKCD Password Generator.
			</div>
	        <div class="card-copy">
            <p>The XKCD password generator strings together commonly used words in a random sequence. The goal is to create a unique password that is easy to recall from memory but difficult to guess.
</p>
            <div id="password"></div>
        </div>
	        <div class="card-config-options">
	        	<hr>	
	        	<div class="radio-group">
				  <h6>To get started, how many words should we use?</h6>
				  <label>Few
				  	<input type="radio" name="numberOfWords" value="few" checked="checked">
				  </label>
				   <label>More
				  	<input type="radio" name="numberOfWords" value="more">
				  </label>
				   <label>Loads
				  	<input type="radio" name="numberOfWords" value="loads">
				  </label>
				 </div>
				<br>
				<div class="switch">
	        		<label>Include a number with that, boss?</label>
	        		<label class="label-switch">
						<input type="checkbox" name="includeNumber" value="on"/>
						<div class="checkbox"></div>
					</label>
				</div>
				<div class="switch">
	        		<label>What about a special symbol?</label>
	        		<label class="label-switch">
						<input type="checkbox" name="includeSpecialSymbol" value="on"/>
						<div class="checkbox"></div>
					</label>
				</div>
				<div class="switch">
	        		<label>Oh, should I capitalize the first letter?</label>
	        		<label class="label-switch">	
						<input type="checkbox" name="capitalizeFirstLetter" value="on"/>
						<div class="checkbox"></div>
					</label>
				</div>
				<hr>
				<div class="card-copy">
					<p>The XKCD password generator can make your password even more complex. Just choose from the following options below.</p>
				</div>
				<div class="radio-group">
					<h6>How's about a we toss in special characters?</h6>
					<label>Few
						<input type="radio" name="specialCharacters" value="few">
					</label>
					<label>More
						<input type="radio" name="specialCharacters" value="more">
					</label>
					<label>Loads
						<input type="radio" name="specialCharacters" value="loads">
					</label>
				</div>
				<br>
				<div class="submit">
					<button id="generate" type="button">
						Generate a password
					</button>
				</div>		
	        </div>
	        <div class="card-stats">
	            <ul>
	                <li>98<span>Items</span></li>
	
	                <li>298<span>Things</span></li>
	
	                <li>923<span>Objects</span></li>
	            </ul>
			</div>
		</div>
    </form>
