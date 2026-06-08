<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIController extends Controller
{
    public function symptomCheck(Request $request)
    {
        $symptoms = strtolower($request->symptoms);
        $result = $this->analyzeSymptoms($symptoms);
        return response()->json(['result' => $result]);
    }

    private function analyzeSymptoms($symptoms)
    {
        $doctors = [];
        $tips = [];

        if (str_contains($symptoms, 'sir') || str_contains($symptoms, 'headache') || str_contains($symptoms, 'sirdard') || str_contains($symptoms, 'migraine') || str_contains($symptoms, 'head')) {
            $doctors[] = '🧠 <strong>Neurologist</strong> — Specialist for headache & brain issues';
            $tips[] = 'Drink plenty of water, take rest, avoid bright lights';
        }

        if (str_contains($symptoms, 'bukhaar') || str_contains($symptoms, 'fever') || str_contains($symptoms, 'bukhar') || str_contains($symptoms, 'temperature') || str_contains($symptoms, 'garmi')) {
            $doctors[] = '🏥 <strong>General Physician</strong> — Specialist for fever & general illness';
            $tips[] = 'Take Paracetamol, use cold compress, stay hydrated';
        }

        if (str_contains($symptoms, 'khansi') || str_contains($symptoms, 'cough') || str_contains($symptoms, 'sans') || str_contains($symptoms, 'saans') || str_contains($symptoms, 'breathing') || str_contains($symptoms, 'chest')) {
            $doctors[] = '🫁 <strong>Pulmonologist</strong> — Specialist for cough & breathing issues';
            $tips[] = 'Drink warm water, take steam, wear a mask in public';
        }

        if (str_contains($symptoms, 'dil') || str_contains($symptoms, 'heart') || str_contains($symptoms, 'seena') || str_contains($symptoms, 'chest pain') || str_contains($symptoms, 'palpitation')) {
            $doctors[] = '❤️ <strong>Cardiologist</strong> — Specialist for heart & chest issues';
            $tips[] = '⚠️ This could be serious — please visit a doctor immediately!';
        }

        if (str_contains($symptoms, 'pet') || str_contains($symptoms, 'stomach') || str_contains($symptoms, 'vomit') || str_contains($symptoms, 'ulti') || str_contains($symptoms, 'diarrhea') || str_contains($symptoms, 'nausea')) {
            $doctors[] = '🫃 <strong>Gastroenterologist</strong> — Specialist for stomach & digestion issues';
            $tips[] = 'Eat light food, drink ORS, avoid spicy & oily food';
        }

        if (str_contains($symptoms, 'jild') || str_contains($symptoms, 'skin') || str_contains($symptoms, 'rash') || str_contains($symptoms, 'itching') || str_contains($symptoms, 'khujli') || str_contains($symptoms, 'allergy')) {
            $doctors[] = '🩺 <strong>Dermatologist</strong> — Specialist for skin issues & allergies';
            $tips[] = 'Do not scratch the affected area, use moisturizer, avoid allergens';
        }

        if (str_contains($symptoms, 'haddi') || str_contains($symptoms, 'bone') || str_contains($symptoms, 'joint') || str_contains($symptoms, 'knee') || str_contains($symptoms, 'back pain') || str_contains($symptoms, 'fracture')) {
            $doctors[] = '🦴 <strong>Orthopedic</strong> — Specialist for bones & joint issues';
            $tips[] = 'Take rest, avoid heavy lifting, apply ice pack on swelling';
        }

        if (str_contains($symptoms, 'child') || str_contains($symptoms, 'baby') || str_contains($symptoms, 'bacha') || str_contains($symptoms, 'infant') || str_contains($symptoms, 'kid')) {
            $doctors[] = '👶 <strong>Pediatrician</strong> — Specialist for children health';
            $tips[] = 'Keep the child hydrated, do not wrap in too many clothes during fever';
        }

        if (str_contains($symptoms, 'eye') || str_contains($symptoms, 'vision') || str_contains($symptoms, 'aankhain') || str_contains($symptoms, 'blur') || str_contains($symptoms, 'nazar')) {
            $doctors[] = '👁️ <strong>Ophthalmologist</strong> — Specialist for eye & vision issues';
            $tips[] = 'Reduce screen time, wash eyes with clean water, avoid rubbing eyes';
        }

        if (str_contains($symptoms, 'teeth') || str_contains($symptoms, 'tooth') || str_contains($symptoms, 'daant') || str_contains($symptoms, 'gum') || str_contains($symptoms, 'dental')) {
            $doctors[] = '🦷 <strong>Dentist</strong> — Specialist for teeth & gum issues';
            $tips[] = 'Gargle with salt water, avoid very hot or cold food';
        }

        if (str_contains($symptoms, 'diabetes') || str_contains($symptoms, 'sugar') || str_contains($symptoms, 'thyroid') || str_contains($symptoms, 'hormone')) {
            $doctors[] = '💉 <strong>Endocrinologist</strong> — Specialist for diabetes & hormonal issues';
            $tips[] = 'Monitor blood sugar regularly, maintain healthy diet, exercise daily';
        }

        if (str_contains($symptoms, 'mental') || str_contains($symptoms, 'anxiety') || str_contains($symptoms, 'depression') || str_contains($symptoms, 'stress') || str_contains($symptoms, 'sleep')) {
            $doctors[] = '🧘 <strong>Psychiatrist / Psychologist</strong> — Specialist for mental health';
            $tips[] = 'Practice meditation, get proper sleep, talk to someone you trust';
        }

        if (str_contains($symptoms, 'kidney') || str_contains($symptoms, 'urine') || str_contains($symptoms, 'gurda') || str_contains($symptoms, 'urinary')) {
            $doctors[] = '🫘 <strong>Nephrologist / Urologist</strong> — Specialist for kidney & urinary issues';
            $tips[] = 'Drink plenty of water, reduce salt intake, avoid holding urine';
        }

        if (empty($doctors)) {
            return '
                <div style="padding:12px; background:white; border-radius:10px; margin-bottom:12px;">
                    <i class="fas fa-info-circle" style="color:#6c5ce7;"></i>
                    <strong> General Advice:</strong><br>
                    <span style="font-size:0.8rem; color:#555;">Based on your symptoms, we recommend visiting a <strong>General Physician</strong> for proper diagnosis.</span>
                </div>
                <div style="padding:10px; background:#fff3cd; border-radius:10px; font-size:0.78rem; color:#856404;">
                    💡 <strong>Tip:</strong> Please describe your symptoms in more detail. Example: headache, fever, cough, stomach pain, chest pain, skin rash, etc.
                </div>
            ';
        }

        $docList = '<ul style="margin:8px 0 0; padding-left:18px;">';
        foreach ($doctors as $d) {
            $docList .= "<li style='margin-bottom:7px;'>$d</li>";
        }
        $docList .= '</ul>';

        $tipList = '<ul style="margin:8px 0 0; padding-left:18px;">';
        foreach ($tips as $t) {
            $tipList .= "<li style='margin-bottom:5px; color:#555;'>$t</li>";
        }
        $tipList .= '</ul>';

        return "
            <div style='margin-bottom:14px; padding:12px; background:white; border-radius:10px;'>
                <i class='fas fa-stethoscope' style='color:#6c5ce7;'></i>
                <strong> Recommended Doctors:</strong>
                $docList
            </div>
            <div style='margin-bottom:14px; padding:12px; background:white; border-radius:10px;'>
                <i class='fas fa-lightbulb' style='color:#f39c12;'></i>
                <strong> Health Tips:</strong>
                $tipList
            </div>
            <div style='padding:10px; background:#fff3cd; border-radius:10px; font-size:0.75rem; color:#856404; margin-bottom:12px;'>
                ⚠️ <strong>Disclaimer:</strong> This is AI-based advice only. Please consult a qualified doctor for proper diagnosis and treatment.
            </div>
            <a href='/doctors' style='background:linear-gradient(135deg,#6c5ce7,#a29bfe); color:white; padding:9px 20px; border-radius:20px; text-decoration:none; font-size:0.8rem; font-weight:600; display:inline-block;'>
                <i class='fas fa-user-md me-1'></i>Book Appointment Now
            </a>
        ";
    }
}