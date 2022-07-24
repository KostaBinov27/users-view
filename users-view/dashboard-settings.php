<?php 
global $usersSuccess;
global $usersSuccess; ?>
<div id="wpbody" role="main">
    <div id="wpbody-content">
        <h1>Users View General Settings</h1>
        <form method="post" id="change_calc_settings" enctype="multipart/form-data">
            <p class="descriptionString">Import the CSV file that was sent with the task, or you can <a href="https://www.onwebmax.com/wp-content/uploads/2022/06/users.csv" target="_blank">download it here</a></p>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label>Import Users</label>
                        </th>
                        <td>
                            <input name="csvDocument" type="file" id="usersFileImport" accept=".csv">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <input type="submit" name="importUsers" id="importUsers" class="button button-primary" value="Import Users" disabled>
                        </th>
                    </tr>
                </tbody>
            </table>
        </form>
        
        <?php do_action( 'print_message' ); ?>

        <p>To use this table of users, please use this shortcode on your website:</p>
        <code>[users-view]</code>
    </div>
</div>