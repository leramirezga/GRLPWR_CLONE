<?php

namespace App\Http\Controllers;

use App\FoodAssesment;
use App\Model\Peso;
use App\PhysicalAssessment;
use App\HealthTest;
use App\TrainingPreference;
use App\User;
use App\WellBeingAssessment;
use App\WheelOfLife;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WellBeingController extends controller {

    /**
     * Display the form to make a health test.
     */
    public function index(User $user)
    {
        return view('cliente.healthTest', compact('user'));
    }

    public function processWellBeingTest(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        DB::transaction(function () use ($request, $user) {
            $physicalAssessment = new PhysicalAssessment();
            $physicalAssessment->user_id = $user->id;
            $physicalAssessment->muscle = $request->muscle;
            $physicalAssessment->visceral_fat = $request->visceral_fat;
            $physicalAssessment->body_fat = $request->body_fat;
            $physicalAssessment->water_level = $request->water_level;
            $physicalAssessment->proteins = $request->proteins;
            $physicalAssessment->basal_metabolism = $request->basal_metabolism;
            $physicalAssessment->bone_mass = $request->bone_mass;
            $physicalAssessment->body_score = $request->body_score;
            $physicalAssessment->save();

            $peso = new Peso();
            $peso->usuario_id = $user->id;
            $peso->peso = $request->weight;
            $peso->unidad_medida = 0;
            $peso->save();

            $foodFormAssesment = new FoodAssesment();
            $foodFormAssesment->user_id = $user->id;
            $foodFormAssesment->feeding_relationship = $request->feeding_relationship;
            $foodFormAssesment->breakfast = $request->breakfast;
            $foodFormAssesment->mid_morning = $request->mid_morning;
            $foodFormAssesment->lunch = $request->lunch;
            $foodFormAssesment->snacks = $request->snacks;
            $foodFormAssesment->dinner = $request->dinner;
            $foodFormAssesment->supplements = $request->supplements;
            $foodFormAssesment->medicines = $request->medicines;
            $foodFormAssesment->happy_food = $request->happy_food;
            $foodFormAssesment->sad_food = $request->sad_food;
            $foodFormAssesment->save();

            $trainingPreference =new TrainingPreference();
            $trainingPreference->user_id = $user->id;
            $trainingPreference->training_frequency = $request->training_frequency;
            $trainingPreference->intensity = $request->intensity;
            $trainingPreference->music = $request->music;
            $trainingPreference->save();

            $wellBeingAssessment = new WellBeingAssessment();
            $wellBeingAssessment->user_id = $user->id;
            $wellBeingAssessment->body_relation = $request->body_relation;
            $wellBeingAssessment->body_discomfort = $request->body_discomfort;
            $wellBeingAssessment->stress = $request->reason_stress;
            $wellBeingAssessment->stress_practice = $request->reason_stress_practice;
            $wellBeingAssessment->spiritual_belief = $request->reason_spiritual_belief;
            $wellBeingAssessment->save();

            $wheelOfLife = new WheelOfLife();
            $wheelOfLife->user_id = $user->id;
            $wheelOfLife->health = $request->health;
            $wheelOfLife->reason_health = $request->reason_health;
            $wheelOfLife->personal_growth = $request->personal_growth;
            $wheelOfLife->reason_personal_growth = $request->reason_personal_growth;
            $wheelOfLife->home = $request->home;
            $wheelOfLife->reason_home = $request->reason_home;
            $wheelOfLife->family_and_friends = $request->family_and_friends;
            $wheelOfLife->reason_family_and_friends = $request->reason_family_and_friends;
            $wheelOfLife->love = $request->love;
            $wheelOfLife->reason_love = $request->reason_love;
            $wheelOfLife->leisure = $request->leisure;
            $wheelOfLife->reason_leisure = $request->reason_leisure;
            $wheelOfLife->work = $request->work;
            $wheelOfLife->reason_work = $request->reason_work;
            $wheelOfLife->money = $request->money;
            $wheelOfLife->reason_money = $request->reason_money;
            $wheelOfLife->user_id = auth()->user()->id;
            $wheelOfLife->save();
        });

        Session::put('msg_level', 'success');
        Session::put('msg', __('general.sucess_wellbeign_assesment'));
        Session::save();
        return redirect()->back();
    }
}
