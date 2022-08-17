<div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="polls">
                <fieldset class="FieldTopic">
                <legend class="topic">Polls</legend>
              </fieldset>
                <div class="posi_rel">
                <p class="polls_head">READ: Recorded on reports damage purpose what variations of beat those</p>
                <div class="down_arrow"> </div>
              </div>
			  
                <div class="BeforePoll">
                <div class="polls_img"> <img src="images/poll.jpg">
                    <p>The magnitude those earthquake was recorded on reports damage variations  those passage ?</p>
                  </div>
                  <table>
                  <tr>
                  <td>
                  <div>
                        <input type="radio" name="vote" value="yes" checked>
                       <label>Yes</label></div>
                    <div>
                        <input type="radio" name="vote" value="no">
                        <label>No</label> </div>
                  </td>
                  <td class="VoteButton">
                  <button type="submit">Vote</button>
                  <button>View Results</button>
                  </td>
                  </tr>
                  </table>
              </div>
              <div class="after-vote">
               <table>
               <tr>
               <th>Result</th>
               </tr>
               <tr>
               <td class="vote-yes">Yes</td>
               <td class="vote-no"><div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="70"
  aria-valuemin="0" aria-valuemax="100" style="width:64%">
    (454)64%
  </div>
</div></td>
               </tr>
               <tr>
               <td class="vote-yes">No</td>
               <td class="vote-no"><div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="70"
  aria-valuemin="0" aria-valuemax="100" style="width:14%">
   (125)14%
  </div>
</div></td>
               </tr>
               <tr>
               <td>Votes so far: 568</td>
               <td class="back-botton"> <button id="back-list">BACK</button></td>
               </tr>
               </table>
                
                </div>
              </div>
          </div>
          </div>
          
          
          
          
          
          
          
          
          
<!-- Script --> 
<script type="text/javascript">
$(document).ready(function(){		 
	 //Poll create
	 $('.VoteButton button').click(function(){
		 $('.BeforePoll').hide();
		 $('.after-vote').show();
	 });
	 $('#back-list').click(function(){
		 $('.BeforePoll').show();
		 $('.after-vote').hide();
	 });
	 
});
</script> 