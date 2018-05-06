<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('SET GLOBAL event_scheduler = ON;');

        DB::unprepared("
            CREATE FUNCTION getLastDayCount() RETURNS INTEGER
            DETERMINISTIC
            BEGIN
                DECLARE total INTEGER;
                SET total = 0;
        
                SELECT COUNT(l.id)
                INTO total
                FROM logs l
                WHERE l.created_at >= (NOW() - INTERVAL 1 DAY);
        
                IF total is NULL THEN
                SET total = 0;
                END IF;
        
                RETURN (total);
            END
        ");

        DB::unprepared("
            CREATE EVENT IF NOT EXISTS recordCount
            ON SCHEDULE EVERY 1 DAY
                STARTS '2018-05-06 23:59:00'
            DO
                BEGIN
                    START TRANSACTION;
                    INSERT INTO counts(operations, created_at) VALUES (getLastDayCount(), NOW());
                    COMMIT;
                END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('SET GLOBAL event_scheduler = OFF;');
        DB::unprepared('DROP EVENT recordCount;');
        DB::unprepared('DROP FUNCTION getLastDayCount;');
    }
}
