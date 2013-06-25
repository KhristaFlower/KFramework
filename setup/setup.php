<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class Setup extends Controller {

    private $_setupTables = array("KF_Admins");
    private $_config_db_file = "config_db.php";

    function __construct($details) {
        parent::__construct($details);

        $this->dataContainer->getContainer("View")->setVariable("MainNav", null);
    }

    public function step($params) {
        // Here we can define certain functions to run depending on the page we
        // are viewing. This is used to perform page specific checks before we
        // render the HTML.
        switch ($params[0]):
            case 1:
                $this->_step1();
                break;
            case 2:
                $this->_step2();
                break;
            case 3:
                $this->_step3();
                break;
            default:
                // Do nothing if we haven't actually set additional tasks.
                break;
        endswitch;
        // Render the page for this step.
        $this->renderSpecificPage("setup/setup_step_{$params[0]}");
    }

    function index() {
        $this->renderSpecificPage("setup/setup_view");
    }

    public function process($args) {
        switch ($args[0]): // Page number
            case 1:
                $this->_process1();
                break;
            case 2:
                $this->_process2($args[1]);
                break;
            case 3:
                $this->_process3();
                break;
            case 4:
                $this->_process4();
                break;
            default:
                die("Process $args[0] is not valid!");
                break;
        endswitch;
    }

    private function _step1() {
        $this->dataContainer->addContainer(new DataContainer("Form"));
        $this->dataContainer->gc("Form")->sv("submit", false);
        $db_details = $this->_checkForValidConfig();
        unset($db_details);
    }

    /**
     * Validate the users database information and save it to a file
     * if it makes a valid connection.
     */
    private function _process1() {
        $this->dataContainer->addContainer(new DataContainer("Form"));
        $form = new Form();
        $form->post('db_name')->validate('required')
                ->post('user_name')->validate('required')
                ->post('user_pass')->validate('required');

        // Set the value on the page so we can let the user know if their data is acceptable.
        $this->dataContainer->getContainer("Form")
                ->setVariable("isErrorFree", $form->isErrorFree())
                ->setVariable("submit", true);

        if ($form->isErrorFree()) {
            // Perform the database test.
            // Assume it will pass...
            $this->dataContainer->sv("hasConnected", true);
            try {
                $databaseTest = new Database("mysql", "localhost", $form->fetch('db_name'), $form->fetch('user_name'), $form->fetch('user_pass'));
                unset($databaseTest);
                // Create the contents for a PHP file containing these details.
                $configOutput = "<?php\n";
                $configOutput .= '$sql_array["user"] = "' . $form->fetch('user_name') . "\";\n";
                $configOutput .= '$sql_array["pass"] = "' . $form->fetch('user_pass') . "\";\n";
                $configOutput .= '$sql_array["db"] = "' . $form->fetch('db_name') . "\";\n";
                $configOutput .= '?>';
                // Assume to begin with that everything will succeed...
                $this->dataContainer->gc("Config")
                        ->sv("isWriteable", true)
                        ->sv("opened", true)
                        ->sv("canWrite", true)
                        ->sv("written", false);
                // Save the details to a file.
                $file = "config_db.php";
                if (!file_exists($file)) {
                    $handle = fopen($file, "w");
                    fclose($handle);
                }
                if (is_writable($file)) {
                    if (!$handle = fopen("config_db.php", "w", TRUE)) {
                        $this->dataContainer->gc("Config")->sv("opened", false);
                    }
                    if (fwrite($handle, $configOutput) === FALSE) {
                        $this->dataContainer->gc("Config")->sv("canWrite", false);
                    }
                    // Close the handle to the file.
                    fclose($handle);
                    // I guess it has passed at this point.
                    $this->dataContainer->gc("Config")->sv("written", true);
                } else {
                    $this->dataContainer->gc("Config")->sv("isWriteable", false);
                }
            } catch (Exception $e) {
                // Connection failed.
                $this->dataContainer->sv("hasConnected", false);
            }
        }

        // Load the first page of the setup.
        $this->step(array(1));
    }

    private function _step2() {
        // Check to see if the tables exist.
        $db_details = $this->_checkForValidConfig();
        if ($db_details != false) {
            require_once 'setup/setup_model.php';
            // Setup Model containing all database interactions we will use here.
            $model = new Setup_Model("mysql", "localhost", $db_details["db"], $db_details["user"], $db_details["pass"]);
            $tablesToCreate = $this->_setupTables;
            $tablesThatExist = $model->getTables();
            $tablesFound = array();
            // Make some assumptions.
            $missingTables = false;
            $foundTables = false;
            foreach ($tablesToCreate as $table) {
                if (array_search($table, $tablesThatExist) !== false) {
                    // TABLE FOUND
                    $tablesFound[$table] = true;
                    $foundTables = true;
                } else {
                    // TABLE NOT FOUND
                    $tablesFound[$table] = false;
                    $missingTables = true;
                }
            }
            $tablesFound = (count($tablesFound) > 0) ? $tablesFound : null;

            $this->dataContainer->addContainer(new DataContainer("Tables"));
            $this->dataContainer->getContainer("Tables")
                    ->setVariable("missingTables", $missingTables)
                    ->setVariable("foundTables", $foundTables)
                    ->setVariable("tableList", $tablesFound);
        }
    }

    /**
     * Create the tables required for the KFramework to operate.
     * @param string 'create' or 'replace', mode for table creation.
     */
    private function _process2($mode) {
        $db_details = $this->_checkForValidConfig();
        if ($db_details != false) {
            // Settings are set.
            require_once 'setup/setup_model.php';
            // Prepare the table objects.
            $model = new Setup_Model();
            // TODO: Eventually relocate the table creation to another function.
            // This can be forgiven for now since there is only one being created.
            $kfTable = new Table("KF_Admins", "utf8", "utf8_general_ci", "ID");
            $kfTable->addColumn("ID", "INT", "3", null, "utf8_general_ci", "unsigned", true, true, false);
            $kfTable->addColumn("Username", "VARCHAR", "30", null, "utf8_general_ci", null, true, false, true);
            $kfTable->addColumn("Email", "VARCHAR", "50", null, "utf8_general_ci", null, true, false, true);
            $kfTable->addColumn("Password", "CHAR", "60", null, "utf8_general_ci", null, true, false, false);
            $kfTable->addColumn("Creation", "INT", "10", null, "utf8_general_ci", "unsigned", true, false, false);
            // Perform the operations on the tables we created.
            if ($mode == "create") {
                $model->createTable($kfTable);
            } else if ($mode == "recreate") {
                $model->recreateTable($kfTable);
            }
        }

        $this->step(array(2));
    }

    private function _step3() {
        $db_details = $this->_checkForValidConfig();
        if ($db_details != false) {
            require_once 'setup/setup_model.php';
            $model = new Setup_Model();
            $accounts = $model->checkForExistingAccounts();
            if (is_array($accounts) && count($accounts) > 0) {
                $this->dataContainer->getContainer("View")
                        ->setVariable("accounts_exist", true)
                        ->setVariable("accounts_created", $accounts);
            }
        }
    }

    private function _process3() {
        $regForm = new Form();
        $regForm->post("Username")
                ->validate(Form::VALIDATE_REQUIRED)
                ->validate(Form::VALIDATE_ALLOWED_CHARS, '/^[A-Za-z0-9-_]+$/')
                ->validate(Form::VALIDATE_MIN_LENGTH, 2)
                ->validate(Form::VALIDATE_MAX_LENGTH, 30)
                ->post("Email")
                ->validate(Form::VALIDATE_REQUIRED)
                ->validate(Form::VALIDATE_MAX_LENGTH, 50)
                ->validate(Form::VALIDATE_EMAIL)
                ->post("Password")
                ->validate(Form::VALIDATE_REQUIRED)
                ->validate(Form::VALIDATE_MIN_LENGTH, 6)
                ->post("Password_Confirmation")
                ->validate(Form::VALIDATE_REQUIRED)
                ->validate(Form::VALIDATE_FIELDS_MATCH, "Password");

        $this->dataContainer->addContainer(new DataContainer("Form"));
        $this->dataContainer->getContainer("Form")
                ->setVariable("account_created", false)
                ->setVariable("registration_failed", false);

        if ($regForm->isErrorFree()) {
            // Form is error free!
            $db_details = $this->_checkForValidConfig();
            if ($db_details != false) {
                require_once 'setup/setup_model.php';
                $model = new Setup_Model();
                // Create an instance of the PasswordHash object.
                $hasher = new PasswordHash(HASHING_COST, HASHING_PORTABLE);
                $hash = $hasher->HashPassword($regForm->fetch("Password"));
                if (strlen($hash) < 20) {
                    // Password hash failed.
                } else {
                    if ($hasher->CheckPassword($regForm->fetch("Password"), $hash)) {
                        // Password was hashed properly and has been verified.
                        // Submit the data to the model for saving in the database.
                        $model->createAccount($regForm->fetch("Username"), $regForm->fetch("Email"), $hash);
                        $this->dataContainer->getContainer("View")
                                ->setVariable("account_created", true);
                    } else {
                        // Hash failed to verify
                    }
                }
            }
        } else {
            // Form has errors!
            $this->dataContainer->getContainer("View")
                    ->setVariable("registration_failed", true)
                    ->setVariable("registration_errors", $regForm->getErrors());
        }
        $this->step(array(3));
    }

    private function _process4() {
        // Here we perform some custom validations, this is because we're checking
        // for a username and an email, the same tests do not apply to both of them.
        $usernameTests = array(
            Form::VALIDATE_REQUIRED => null,
            Form::VALIDATE_ALLOWED_CHARS => '/^[A-Za-z0-9-_]+$/',
            Form::VALIDATE_MIN_LENGTH => 2,
            Form::VALIDATE_MAX_LENGTH => 30
        );
        $emailTests = array(
            Form::VALIDATE_REQUIRED => null,
            Form::VALIDATE_MAX_LENGTH => 50,
            Form::VALIDATE_EMAIL => null
        );

        $usernameTest = $this->_customTest("UorE", $usernameTests);
        $emailTest = $this->_customTest("UorE", $emailTests);

        require_once 'setup/setup_model.php';
        $model = new Setup_Model();

        $this->dataContainer->getContainer("View")
                ->setVariable("login_success", false);

        $hashedPass = null;

        if ($usernameTest && !$emailTest) {
            // Login using the Username.
            $hashedPass = $model->getLoginDetails("Username", $_POST['UorE']);
        } else if (!$usernameTest && $emailTest) {
            // Login using the Email.
            $hashedPass = $model->getLoginDetails("Email", $_POST['UorE']);
        } else {
            // Both failed.
        }

        if ($hashedPass != null) {
            $hasher = new PasswordHash(HASHING_COST, HASHING_PORTABLE);
            if ($hasher->CheckPassword($_POST['Password'], $hashedPass)) {
                $this->dataContainer->getContainer("View")
                        ->setVariable("login_success", true);
            }
        }

        $this->step(array(4));
    }

    public function complete() {
        $this->renderSpecificPage("setup/setup_complete");
    }

    private function _customTest($fieldName, $validationArray) {
        $testForm = new Form();
        $testForm->post($fieldName);
        $testPassed = true;
        // Perform each test and make a note if it fails.
        foreach ($validationArray as $validationConst => $arg) {
            if ($arg != null) {
                $testForm->validate($validationConst, $arg);
            } else {
                $testForm->validate($validationConst);
            }
        }
        if (!$testForm->isErrorFree()) {
            $testPassed = false;
        }
        return $testPassed;
    }

    private function _checkForValidConfig() {
        $this->dataContainer->addContainer(new DataContainer("Config"));
        $this->dataContainer->gc("Config")
                ->sv("error", false)
                ->sv("missing", false)
                ->sv("invalidSettings", false)
                ->sv("valid", false);

        $file = $this->_config_db_file;
        if (file_exists($file)) {
            // Config file exists.
            $sql_array = array();
            require $file;
            if (isset($sql_array["user"], $sql_array["pass"], $sql_array["db"])) {
                // Settings are set.
                $this->dataContainer->gc("Config")
                        ->sv("valid", true)
                        ->sv("user", $sql_array["user"])
                        ->sv("database", $sql_array["db"]);
                return $sql_array;
            } else {
                $this->dataContainer->gc("Config")->sv("invalidSettings", true);
            }
        } else {
            $this->dataContainer->gc("Config")->sv("missing", true);
        }
        $this->dataContainer->gc("Config")->sv("error", true);
        return false;
    }

}
