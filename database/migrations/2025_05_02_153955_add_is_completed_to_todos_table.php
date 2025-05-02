public function up()
{
    Schema::table('todos', function (Blueprint $table) {
        $table->boolean('is_completed')->default(false);
    });
}

public function down()
{
    Schema::table('todos', function (Blueprint $table) {
        $table->dropColumn('is_completed');
    });
}
