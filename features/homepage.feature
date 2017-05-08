Feature: Homepage Content
  In order to use the facebook website
  As anonymous user
  I need to see the homepage header, navigation and content

Scenario: Check homepage content
  Given I have a web browser
  When  I load the homepage
  Then  I should see "Create an account"
  And   I should see "Facebook"
  And   I Should see "Forgotten account?"  link
  And   I Should see "Create a Page"  link