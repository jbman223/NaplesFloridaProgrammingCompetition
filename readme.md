
Naples Florida Programming Competition
===================

Certain portions of the http://programmingcompetition.org website have been made open source in order to facilitate the continuation of the Naples Florida Programming Competition.

----------


Local deployment of the front end
-------------

The Naples Florida Programming Competition website can be installed locally or on any web server that supports PHP and MySQL.

1.  Clone the repository:

        git clone https://github.com/jbman223/NaplesFloridaProgrammingCompetition.git

2. Create the required configuration files:

         cd NaplesFloridaProgrammingCompetition
         cd config
         cp db.default.php db.php
         cp mandrill_config.default.php mandrill_config.php

     Edit `db.php` and `mandrill_config.php` with your settings.
     

     > **Note**
     > You do not need to insert Mandrill settings for the local deployment to function properly, however you will not be able to send emails (impacts account creation).

     Create copies of your configuration files in the proper folders:
 

        cp db.php ../db.php
        cp db.php ../includes/db.php
        cp mandrill_config.php ../mail/mandrill_config.php


3. Set up the database schema:
     To set up the proper database schema, run the layout SQL found in `config/programmingcompetition_layout.sql`.

Contributing 
----------

1. Clone the Repo:

        git clone https://github.com/jbman223/NaplesFloridaProgrammingCompetition.git

2. Create a new Branch:

        cd NaplesFloridaProgrammingCompetition
        git checkout -b new_branch_names

   Please keep your code clean, and limit each branch to one feature or bug-fix. If
   you find multiple bugs you want to fix, make multiple branches and multiple
   respective pull requests.

3. Code
  * Adhere to common conventions you see in the existing code
  * Search to see if your new functionality has been discussed on [the Issue
    Tracker](https://github.com/jbman223/NaplesFloridaProgrammingCompetition/issues), and include updates as appropriate
    
4. Commit

  Crafting good commit messages is a fine art. Good commit messages help
  organize your thoughts, document your thought for your future self, and
  communicate to the team why this commit was necessary.

  Please follow the conventions described by Tim Pope in [_A Note About Good
  Commit Messages_][commit-messages].


5. Update your branch with changes on master

  ```
  git checkout <YOUR_BRANCH_NAME>
  git fetch origin
  git rebase origin/master
  ```

6. Push branch to NaplesFloridaProgrammingCompetition repo

  ```
  git push origin <YOUR_BRANCH_NAME>
  ```

7. Issue a Pull Request

  In order to make a pull request,

  * Navigate to the NaplesFloridaProgrammingCompetition repository you just pushed to (e.g.
    https://github.com/jbman223/NaplesFloridaProgrammingCompetition)
  * Click "Pull Request" and "New Pull Request".
  * Write your branch name in the branch field (this is filled with `master` by
    default)
  * Pick `master` branch as the target branch on GitHub
  * Ensure the changesets you introduced are included in the "Commits" tab.
  * Ensure that the "Files Changed" incorporate all of your changes.
  * Fill in some details about your potential patch including a meaningful
    title.
  * Click "Send pull request".

8. Responding to Feedback

  The ProgrammingCompetition.org team may recommend adjustments to your code. Part of interacting with a healthy open-source community requires you to be open to learning new
  techniques and strategies; *don't get discouraged!* Remember: if the ProgrammingCompetition.org
  team suggest changes to your code, **they care enough about your work that
  they want to include it**, and hope that you can assist by implementing those
  revisions on your own.


