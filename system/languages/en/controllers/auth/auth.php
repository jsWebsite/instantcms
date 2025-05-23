<?php

define('LANG_AUTH_CONTROLLER', 'Authorization & Registration');
define('LANG_AUTHORIZATION', 'Authorization');
define('LANG_RULE_AUTH_VIEW_CLOSED', 'Access to the disabled site');
define('LANG_AUTH_RESTRICTIONS', 'Restrictions');
define('LANG_AUTH_DISABLE_RESTORE', 'Disable password recovery');
define('LANG_AUTH_RESTRICTED_EMAILS', "Restricted e-mails");
define('LANG_AUTH_RESTRICTED_EMAILS_HINT', 'One address per line, you can use * as a wildcard');
define('LANG_AUTH_RESTRICTED_EMAIL', 'E-mail <b>%s</b> is forbidden');
define('LANG_AUTH_RESTRICTED_NAMES', 'Restricted nicknames');
define('LANG_AUTH_RESTRICTED_NAMES_HINT', 'One nickname per line, you can use * as a wildcard');
define('LANG_AUTH_RESTRICTED_NAME', 'Nickname <b>%s</b> is forbidden');
define('LANG_AUTH_RESTRICTED_IPS', 'IPs restricted for registration');
define('LANG_AUTH_RESTRICTED_IPS_HINT', 'One address per line, you can use * as a wildcard');
define('LANG_AUTH_RESTRICTED_IP', 'Registration from IP <b>%s</b> is forbidden');
define('LANG_AUTH_INVITES', 'Invites');
define('LANG_AUTH_SEND_INVITES', 'Send invitations');
define('LANG_AUTH_REVOKE_INVITES', 'Revoke all invitations');
define('LANG_AUTH_INVITE_SEND_COUNT', 'You have received %s');
define('LANG_AUTH_INVITE_SENDED', 'Invites sent');
define('LANG_AUTH_INVITE_REVOKED', 'Invites are revoked');
define('LANG_AUTH_INVITE_NOTIFY', 'At your invitation, <a href="%s">%s</a> registered');
define('LANG_AUTH_INVITES_AUTO', 'Issue invites to registered users');
define('LANG_AUTH_INVITES_AUTO_HINT', 'Users will be able to send invites to their friends');
define('LANG_AUTH_INVITES_STRICT', 'Bind invites to e-mail');
define('LANG_AUTH_INVITES_STRICT_HINT', 'If enabled, a user will be able to register with an invite code received via e-mail only');
define('LANG_AUTH_INVITES_PERIOD', 'Issue invites once in the period of');
define('LANG_AUTH_INVITES_QTY', 'How many invites to issue');
define('LANG_AUTH_INVITES_KARMA', 'Issue invites to users whose reputation is higher than');
define('LANG_AUTH_INVITES_RATING', 'Issue invites to users whose rating is higher than');
define('LANG_AUTH_INVITES_DATE', 'Issue invites to users registered on the site for at least');
define('LANG_REG_INVITED_ONLY', 'Registration is allowed by invites only');
define('LANG_REG_INVITE_CODE', 'Invite code');
define('LANG_REG_WRONG_INVITE_CODE', 'Wrong invite code');
define('LANG_REG_WRONG_INVITE_CODE_EMAIL', 'Invite code assigned to another e-mail');
define('LANG_REG_CFG_IS_ENABLED', 'Registration is enabled');
define('LANG_REG_CFG_DISABLED_NOTICE', 'Reason why registration is disabled');
define('LANG_REG_CFG_IS_INVITES', 'Registration is by invitation only');
define('LANG_REG_CFG_REG_CAPTCHA', 'Show CAPTCHA to protect from spam registrations');
define('LANG_REG_CFG_AUTH_CAPTCHA', 'Show CAPTCHA on log in');
define('LANG_REG_CFG_NOTIFY_OLD_AUTH', 'Show password change warning');
define('LANG_REG_CFG_NOTIFY_OLD_AUTH_HINT', 'For users registered to InstantCMS version 2.12.1, to switch to a <a target="_blank" href="https://docs.instantcms.ru/manual/components/auth#вкладка-авторизация">new password storage system</a>.');
define('LANG_REG_CFG_FIRST_AUTH_REDIRECT', 'After first login');
define('LANG_REG_CFG_GUESTS_ALLOW_CONTROLLERS', 'Components available without authorization');
define('LANG_REG_CFG_AUTH_REDIRECT', 'After consequent authorization');
define('LANG_REG_CFG_AUTH_2FA', 'Two-Factor Authentication');
define('LANG_REG_TWOFA_APP', 'Authentication application');
define('LANG_REG_CFG_AUTH_REDIRECT_NONE', 'Stay on page, at which the logged');
define('LANG_REG_CFG_AUTH_REDIRECT_INDEX', 'Open homepage');
define('LANG_REG_CFG_AUTH_REDIRECT_PROFILE', 'Open profile');
define('LANG_REG_CFG_AUTH_REDIRECT_PROFILEEDIT', 'Open profile settings');
define('LANG_REG_CFG_VERIFY_EMAIL', 'Send verification e-mail after registration');
define('LANG_REG_CFG_VERIFY_EMAIL_HINT', 'New users will be blocked until they open URL from verification e-mail');
define('LANG_REG_CFG_REG_AUTO_AUTH', 'Login after registration');
define('LANG_REG_CFG_VERIFY_EXPIRATION', 'Delete unverified accounts after, hours');
define('LANG_REG_CFG_VERIFY_LOCK_REASON', 'E-mail verification required');
define('LANG_REG_CFG_DEF_GROUP_ID', 'Add new users to groups');
define('LANG_REG_CFG_SEND_GREETMSG', 'Send notification after registration');
define('LANG_REG_CFG_GREETMSG', 'Notification text');
define('LANG_REG_INCORRECT_EMAIL', 'E-mail address is incorrect');
define('LANG_REG_EMAIL_EXISTS', 'This e-mail address is already registered');
define('LANG_REG_PASS_NOT_EQUAL', 'Passwords do not match');
define('LANG_REG_PASS_EMPTY', 'Password is required');
define('LANG_REG_SUCCESS', 'Registration was successful');
define('LANG_REG_SUCCESS_NEED_VERIFY', 'Verification e-mail was sent to <b>%s</b>. Click on the link in the message to activate your account');
define('LANG_REG_SUCCESS_VERIFIED', 'E-mail address has been successfully verified. You can login now.');
define('LANG_REG_SUCCESS_VERIFIED_AND_AUTH', 'E-mail address has been successfully verified. Welcome!');
define('LANG_VERIFY_EMAIL_ERROR', 'User with this verification code not found. Is possible already activated or activation time is expired');
define('LANG_VERIFY_EMAIL_CODE', 'Registration verification code');
define('LANG_PROCESS_VERIFY_EMAIL', 'E-mail Verification');
define('LANG_RESTORE_TOKEN_EXPIRED', 'Password recovery request is expired ');
define('LANG_RESTORE_TOKEN_IS_SEND', 'Password recovery instruction has been sent, check the "Spam" folder');
define('LANG_RESTORE_BLOCK', 'Account is blocked');
define('LANG_RESTORE_IS_DELETED', 'Account is deleted');
define('LANG_PASS_RESTORE', 'Password Recovery');
define('LANG_EMAIL_NOT_FOUND', 'This e-mail not found in our database');
define('LANG_TOKEN_SENDED', 'We sent you an e-mail with further instructions on password recovery');
define('LANG_RESTORE_NOTICE', 'Please enter the e-mail address with which you registered.<br/>Instructions for password recovery will be sent to the specified address.');
define('LANG_AUTH_INVITES_STARGET', 'To whom to issue invitations');
define('LANG_AUTH_INVITES_SGROUP', 'Group of users');
define('LANG_AUTH_INVITES_SUSER', 'Or user');
define('LANG_AUTH_INVITES_SPARAMS', 'Issuing parameters to a group of users');
define('LANG_AUTH_IS_OLD_AUTH', 'You have not changed your password for a long time, <a href="%s">you can do it now</a>.');
define('LANG_AUTH_CLEAN_REG_EMAIL', 'I entered an invalid email');
define('LANG_AUTH_REG_AUTH', 'Login details');
