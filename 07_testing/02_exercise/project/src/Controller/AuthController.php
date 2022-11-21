<?php

namespace Controller;

use Concept\Distinguishable;
use Exception as ExceptionAlias;
use Model\Flagi;
use Model\User;
use Storage\Exception\StorageException;

class AuthController extends Controller
{
    public function index(): Result
    {
        return view('auth.index')->withTitle("Auth");
    }

    /**
     * @throws StorageException
     * @throws ExceptionAlias
     */
    public function register(): Result
    {
        if (isset($_POST["id"])) {
            if (!(!$_POST["id"] or !$_POST["name"] or !$_POST["surname"] or !$_POST["email"] or !$_POST["password"] or !$_POST["password_confirmation"] or $_POST["password"] != $_POST["password_confirmation"])) {
                $user = new User((int) $_POST["id"]);
                $user->name = $_POST["name"];
                $user->surname = $_POST["surname"];
                $user->email = $_POST["email"];
                $user->password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                //$this->save_model("sqlite", $user);
                $this->save_model("mysql", $user);
                return view('auth.confirmation_notice')->withTitle("Confirmation notice")->withLocation('/auth/confirmation_notice');
            }
        }
        return view('auth.register')->withTitle("Register");
    }

    public function confirm(string $token): Result
    {
        return view("home.InvalidToken")->withLocation("/InvalidToken");
    }

    /**
     * @throws StorageException
     */
    private function save_model(string $type, Distinguishable $user): void
    {
        $storage = $this->storage($type);

        $storage->store($user);
    }

    public function confirmation_notice(): Result
    {
        return view('auth.confirmation_notice')->withTitle("Confirmation notice");
    }

    /**
     * @throws StorageException
     */
    private function find_model_email(string $type, string $email): bool
    {
        $storage = $this->storage($type);
        $disting = $storage->load("model_user*");
        foreach ($disting as $user) {
            if ($user instanceof User) {
                if ($user->email == $email) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @throws StorageException
     */
    public function login(): Result
    {
        if (isset($_POST["email"]) and isset($_POST["password"])) {
            if ($_POST["email"] != '' and $_POST["password"] != '') {
                if ($this->find_model_email('mysql', $_POST["email"])) {
                    return view('auth.login')->withTitle("Login");
                } else {
                    $flag = new Flagi(2);
                    $flag->email = $_POST["email"];
                    $this->save_model('session', $flag );
                    return redirect('/');
                }
            }
        }
        return view('auth.login')->withTitle("Login");
    }
}
