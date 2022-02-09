<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateWkFirewallTable extends Migration
{
    public function up()
    {
        Schema::create(config('wk-core.table.firewall.settings'), function (Blueprint $table) {
            $table->uuid('id');
            $table->nullableUuidMorphs('host');
            $table->nullableUuidMorphs('morph');
            $table->string('serial')->nullable();
            $table->string('identifier')->nullable();
            $table->string('is_whitelist')->default(0);
            $table->boolean('is_enabled')->default(0);

            $table->timestampsTz();
            $table->softDeletes();

            $table->primary('id');
            $table->index('identifier');
            $table->index('is_whitelist');
            $table->index('is_enabled');
        });
        if (!config('wk-firewall.onoff.core-lang_core')) {
            Schema::create(config('wk-core.table.firewall.settings_lang'), function (Blueprint $table) {
                $table->uuid('id');
                $table->uuidMorphs('morph');
                $table->uuid('user_id')->nullable();
                $table->string('code');
                $table->string('key');
                $table->text('value')->nullable();
                $table->boolean('is_current')->default(1);

                $table->timestampsTz();
                $table->softDeletes();

                $table->foreign('user_id')->references('id')
                    ->on(config('wk-core.table.user'))
                    ->onDelete('set null')
                    ->onUpdate('cascade');

                $table->primary('id');
            });
        }

        Schema::create(config('wk-core.table.firewall.items'), function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('setting_id');
            $table->uuid('user_id');

            $table->timestampsTz();
            $table->softDeletes();

            $table->foreign('setting_id')->references('id')
                  ->on(config('wk-core.table.firewall.settings'))
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('user_id')->references('id')
                  ->on(config('wk-core.table.user'))
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->primary('id');
        });
    }

    public function down() {
        Schema::dropIfExists(config('wk-core.table.firewall.items'));
        Schema::dropIfExists(config('wk-core.table.firewall.settings_lang'));
        Schema::dropIfExists(config('wk-core.table.firewall.settings'));
    }
}
