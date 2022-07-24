<?php $users = get_users();
if ( current_user_can( 'manage_options' ) ) { ?>
    <div class="mar-top-5 mar-bot-5">
        <h3>Users</h3>
        <table id="userTable" >
            <thead>
                <tr>
                    <th>Username</th>
                    <th>E-mail Address</th>
                    <th>User Role</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($users as $user){ ?>
                        <tr>
                            <td>
                                <?php print_r($user->user_login); ?>
                            </td>
                            <td>
                                <?php print_r($user->user_email); ?>
                            </td>
                            <td>
                                <?php print_r($user->roles[0]); ?>
                            </td>
                        </tr>
                    <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <h2>You are not Administrator and you cannot view the table!</h2>
<?php } ?>
