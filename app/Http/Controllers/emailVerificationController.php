<?php

namespace App\Http\Controllers;

use App\Models\userVerification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class emailVerificationController extends Controller


{
    public function verificationCreation($username, $tokenLink)
    {
        $userVer = userVerification::where("userName", $username)->where("verificationToken", $tokenLink)->first();
        if ($userVer) {
            $currentTime = now();
            if ($userVer->emailStatus == "false") {
                if ($currentTime < $userVer->expireVerification) {

                    $status = $userVer->update([
                        "emailStatus" => "true"
                    ]);
                    if (!$status) {
                        return (
                            Inertia::render("emailNotVerified", [
                                "reason" => "Something wrong happened, Please try again later or contact the customer care"
                            ])
                        );
                    } else {
                        return (
                            Inertia::render("verifiedEmail")
                        );
                    }
                } else {
                    return (
                        Inertia::render("emailNotVerified", [
                            "reason" => "Verification token expired. Verification token lasts only 24 hours. When you receive the email please follow the instructions." . $currentTime
                        ])
                    );
                }
            } else {
                return (
                    Inertia::render("emailNotVerified", [
                        "reason" => "Email already verified. The token is invalid"
                    ])
                );
            }
        } else {
            return (
                Inertia::render("emailNotVerified", [
                    "reason" => "User not found. Please try again later"
                ])
            );
        }
    }
}
