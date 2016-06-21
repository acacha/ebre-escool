<!--
	-we have our html form here where user information will be entered
	-we used the 'required' html5 property to prevent empty fields
-->
<form id='addUserForm' action='#' method='post' border='0' >
    <table>
        <tr>
            <td>incident_student_id</td>
            <td><input type='text' name='incident_student_id' required /></td>
        </tr>
        <tr>
            <td>incident_time_slot_id</td>
            <td><input type='text' name='incident_time_slot_id' required /></td>
        </tr>
        <tr>
            <td>incident_day</td>
            <td><input type='text' name='incident_day' required /></td>
        </tr>
        <tr>
            <td>incident_study_submodule_id</td>
            <td><input type='text' name='incident_study_submodule_id' required /></td>
        </tr>
        <tr>
            <td>incident_date</td>
            <td><input type='text' name='incident_date' required /></td>
        </tr>
        <tr>
            <td>incident_study_submodule_id</td>
            <td><input type='text' name='incident_study_submodule_id' required /></td>
        </tr>
        <tr>
            <td>incident_type</td>
            <td><input type='text' name='incident_type' required /></td>
        <tr>
            <tr>
            <td>incident_notes</td>
            <td><input type='text' name='incident_notes' required /></td>
        <tr>
            <tr>
            <td>incident_last_update</td>
            <td><input type='text' name='incident_last_update' required /></td>
        <tr>
            <tr>
            <td>incident_creationUserId</td>
            <td><input type='text' name='incident_creationUserId' required /></td>
        <tr>
        <tr>
            <td>incident_lastupdateUserId</td>
            <td><input type='text' name='incident_lastupdateUserId' required /></td>
        <tr>
            <tr>
            <td>incident_markedForDeletion</td>
            <td><input type='text' name='incident_markedForDeletion' required /></td>
        <tr>
            <tr>
            <td>incident_markedForDeletionDate</td>
            <td><input type='text' name='incident_markedForDeletionDate' required /></td>
        <tr>
            <td></td>
            <td>                
                <input type='submit' value='Save' class='customBtn' />
            </td>
        </tr>
    </table>
</form>