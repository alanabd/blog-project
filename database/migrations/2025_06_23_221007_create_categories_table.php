public function up()
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique(); // Kategori adı benzersiz olmalı
        $table->string('slug')->unique(); // Slug da benzersiz olmalı
        $table->timestamps();
    });
}