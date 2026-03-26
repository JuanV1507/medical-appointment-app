<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();


            //añadimos campos
            $table->foreignId('user_id')
                ->constrained('users')
                //Si boorra un usuario, borra el paciente tambien
                ->onDelete('cascade');

                $table->foreignId('blood_type_id')
                    ->nullable()
                    ->constrained('blood_types')
                    ->onDelete('set null');

                $table->String('allergies')
                    ->nullable();    

                    $table->String('chronic_conditions')
                    ->nullable();

                    $table->String('surgical_history')
                    ->nullable();

                    $table->String('family_history')
                    ->nullable();

                    $table->date('observations')
                    ->nullable();

                    $table->date('emergency_contact_name')
                    ->nullable();

                   $table->date('emergency_contact_phone')
                    ->nullable();   

                  $table->date('emergency_contact_relationship')
                    ->nullable();
                    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
