<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');                 // 符号なしBIGINTを使用した自動増分ID（主キー）
            $table->timestamps();                        // NULL値可能なcreated_atとupdated_atカラム追加

            $table->string('title', 64)->nullable();     // オプションの文字長を指定したVARCHARカラム
            $table->text('content')->nullable();         // TEXTカラム

            $table->binary('data')->nullable();          // BLOBカラム
            $table->boolean('confirmed')->nullable();    // BOOLEANカラム
            $table->decimal('amount', 8, 2)->nullable(); // 有効（全体桁数）／小数点以下桁数指定のDECIMALカラム
            $table->ipAddress('visitor')->nullable();    // IPアドレスカラム
            $table->json('options')->nullable();         // JSONフィールド
            $table->longText('description')->nullable(); // LONGTEXTカラム
            $table->macAddress('device')->nullable();    // MACアドレスカラム
            $table->uuid('guid')->nullable();            // UUIDカラム

            /*
            // データ型
            $table->bigInteger('votes');             // BIGINTカラム
            $table->char('name', 100);               // オプションの文字長を指定するCHARカラム
            $table->date('created_at');              // DATEカラム
            $table->dateTime('created_at');          // DATETIMEカラム
            $table->dateTimeTz('created_at');        // タイムゾーン付きDATETIMEカラム
            $table->double('amount', 8, 2);          // 有効（全体桁数）／小数点以下桁数指定のDOUBLEカラム
            $table->enum('level', ['easy', 'hard']); // ENUMカラム
            $table->float('amount', 8, 2);           // 有効（全体桁数）／小数点以下桁数指定のFLOATカラム
            $table->geometry('positions');           // GEOMETRYカラム
            $table->geometryCollection('positions'); // GEOMETRYCOLLECTIONカラム
            $table->increments('id');                // 符号なしINTを使用した自動増分ID（主キー）
            $table->integer('votes');                // INTEGERカラム
            $table->jsonb('options');                // JSONBフィールド
            $table->lineString('positions');         // LINESTRINGカラム
            $table->mediumIncrements('id');          // 符号なしMEDIUMINTを使用した自動増分ID（主キー）
            $table->mediumInteger('votes');          // MEDIUMINTカラム
            $table->mediumText('description');       // MEDIUMTEXTカラム
            $table->morphs('taggable');              // 符号なしINTERGERのtaggable_idと文字列のtaggable_typeを追加
            $table->multiLineString('positions');    // MULTILINESTRINGカラム
            $table->multiPoint('positions');         // MULTIPOINTカラム
            $table->multiPolygon('positions');       // MULTIPOLYGONカラム
            $table->nullableMorphs('taggable');      // NULL値可能なmorphs()カラム
            $table->nullableTimestamps();            // timestamps()メソッドの別名
            $table->point('position');               // POINTカラム
            $table->polygon('positions');            // POLYGONカラム
            $table->rememberToken();                 // VARCHAR(100)でNULL値可能なremember_tokenを追加
            $table->smallIncrements('id');           // 符号なしSMALLINTを使用した自動増分ID（主キー）
            $table->smallInteger('votes');           // SMALLINTカラム
            $table->softDeletes();                   // ソフトデリートのためにNULL値可能なdeleted_at TIMESTAMPカラム追加
            $table->softDeletesTz();                 // ソフトデリートのためにNULL値可能なdeleted_atタイムゾーン付きTIMESTAMPカラム追加
            $table->time('sunrise');                 // TIMEカラム
            $table->timeTz('sunrise');               // タイムゾーン付きTIMEカラム
            $table->timestamp('added_on');           // TIMESTAMPカラム
            $table->timestampTz('added_on');         // タイムゾーン付きTIMESTAMPカラム
            $table->timestampsTz();                  // タイムゾーン付きのNULL値可能なcreated_atとupdated_atカラム追加
            $table->tinyIncrements('id');            // 符号なしTINYINTを使用した自動増分ID（主キー）
            $table->tinyInteger('votes');            // TINYINTカラム
            $table->unsignedBigInteger('votes');     // 符号なしBIGINTカラム
            $table->unsignedDecimal('amount', 8, 2); // 有効（全体桁数）／小数点以下桁数指定の符号なしDECIMALカラム
            $table->unsignedInteger('votes');        // 符号なしINTカラム
            $table->unsignedMediumInteger('votes');  // 符号なしMEDIUMINTカラム
            $table->unsignedSmallInteger('votes');   // 符号なしSMALLINTカラム
            $table->unsignedTinyInteger('votes');    // 符号なしTINYINTカラム
            $table->year('birth_year');              // YEARカラム

            // 修飾子
            ->after('column')                        // 指定カラムの次に他のカラムを設置(MySQLのみ)
            ->autoIncrement()                        // 整数カラムを自動増分ID（主キー）へ設定
            ->charset('utf8')                        // カラムへキャラクタセットを指定(MySQLのみ)
            ->collation('utf8_unicode_ci')           // カラムへコロケーションを指定(MySQL/SQL Serverのみ)
            ->comment('my comment')                  // カラムにコメント追加(MySQLのみ)
            ->default($value)                        // カラムのデフォルト(default)値設定
            ->first()                                // カラムをテーブルの最初(first)に設置する(MySQLのみ)
            ->nullable($value = true)                // （デフォルトで）NULL値をカラムに挿入する
            ->storedAs($expression)                  // stored generatedカラムを生成(MySQLのみ)
            ->unsigned()                             // 整数カラムを符号なしに設定(MySQLのみ)
            ->useCurrent()                           // TIMESTAMPカラムのデフォルト値をCURRENT_TIMESTAMPに指定
            ->virtualAs($expression)                 // virtual generatedカラムを生成(MySQLのみ)

            // インデックス
            $table->primary('id');                   // 主キー追加
            $table->primary(['id', 'parent_id']);    // 複合キー追加
            $table->unique('email');                 // uniqueキー追加
            $table->index('state');                  // 基本的なインデックス追加
            $table->spatialIndex('location');        // 空間インデックス追加(SQLite以外)
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
