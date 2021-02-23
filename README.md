# ptslack
 simple slack integration wordpress plugin


# generating slack app access token
1- you will need to create a slack app throught slack api interactive UI to get an access token to insert in the plugin settings page.
2- visit https://api.slack.com/apps and create your app, you will need to choose an app name and a Slack Workspace to associate the token with.
3- in the next step choose "OAuth & Permissions" from the sidebar, then scroll down to "Scopes" section.
4- add the following OAuth scopes to "Bot Token Scopes" which is required to generate the appropriate access token for the task
  a- channels:manage
  b- channels:read
  c- groups:read
  d- groups:write
  e- im:read
  f- im:write
  g- mpim:read
  h- mpim:write
  
5- press "Install to workspace" and copy the generated access token and save it in plugin settings page.


# Notice
upon plugin activation new pages will be created in your active theme with the title "Slack Channels" & "Create Slack Channel", visit those pages to test the plugin features.
