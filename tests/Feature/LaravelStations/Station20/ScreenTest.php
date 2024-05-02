<?php

namespace Tests\Feature\LaravelStations\Station20;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Screen;
use App\Models\Reservation;
use App\Models\Sheet;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group station20
 */
class ScreenTest extends TestCase
{
    use RefreshDatabase;

    private $movieId;
    private $screenId;
    private $screenId2;
    private $sheetId;

    public function setUp() : void
    {
        parent::setUp();

        $this->screenId = Screen::create(['name' => '1'])->id;
        $this->screenId2 = Screen::create(['name' => '2'])->id;
        Screen::create(['name' => '3']);

        $this->sheetId = Sheet::create([
            'column' => 1,
            'row' => 'a',
        ])->id;

        $this->movieId = Movie::create([
            'title' => '映画タイトル',
            'image_url' => 'https://example.com/image.jpg',
            'published_year' => 2021,
            'description' => '映画の説明',
            'is_showing' => true,
            'genre_id' => Genre::create(['name' => 'ジャンル名'])->id,
        ])->id;
    }

    public function testスケジュールが作成できるか() : void
    {
        $startTime = new Carbon('2021-01-01 10:00:00');
        $endTime = new Carbon('2021-01-01 12:00:00');

        $this->assertDatabaseCount('schedules', 0);

        $response = $this->post('/admin/movies/'. $this->movieId .'/schedules/store', [
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time_date' => $startTime->format('Y-m-d'),
            'start_time_time' => $startTime->format('H:i'),
            'end_time_date' => $endTime->addHour()->format('Y-m-d'),
            'end_time_time' => $endTime->addHour()->format('H:i'),
        ]);

        $response->assertStatus(302);
        // errorを表示
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseCount('schedules', 1);

    }

    public function testRequiredバリデーション（screen_id）が設定されているか() : void 
    {
        $this->assertDatabaseCount('schedules', 0);

        $data = [
            'movie_id' => $this->movieId,
            'start_time_date' => '2021-01-01',
            'start_time_time' => '10:00',
            'end_time_date' => '2021-01-01',
            'end_time_time' => '12:00',
        ];

        $response = $this->post('/admin/movies/'. $this->movieId .'/schedules/store', $data);
        
        $response->assertStatus(302);
        $response->assertInvalid('screen_id');

        $this->assertDatabaseCount('schedules', 0);
    }

    public function test同一スクリーンで異なる時間帯のスケジュールが作成できるか() : void
    {
        $startTime1 = new Carbon('2021-01-01 10:00:00');
        $endTime1 = new Carbon('2021-01-01 12:00:00');
        $startTime2 = new Carbon('2021-01-01 14:00:00');
        $endTime2 = new Carbon('2021-01-01 16:00:00');

        $this->assertDatabaseCount('schedules', 0);

        $response = $this->post('/admin/movies/'. $this->movieId .'/schedules/store', [
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time_date' => $startTime1->format('Y-m-d'),
            'start_time_time' => $startTime1->format('H:i'),
            'end_time_date' => $endTime1->addHour()->format('Y-m-d'),
            'end_time_time' => $endTime1->addHour()->format('H:i'),
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('schedules', 1);

        $response = $this->post('/admin/movies/'. $this->movieId .'/schedules/store', [
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time_date' => $startTime2->addDay()->format('Y-m-d'),
            'start_time_time' => $startTime2->addDay()->format('H:i'),
            'end_time_date' => $endTime2->addDay()->format('Y-m-d'),
            'end_time_time' => $endTime2->addDay()->format('H:i'),
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('schedules', 2);
    }

    public function test異なるスクリーンで同じ時間帯のスケジュールが作成できるか() : void
    {
        $startTime = new Carbon('2021-01-01 10:00:00');
        $endTime = new Carbon('2021-01-01 12:00:00');

        $this->assertDatabaseCount('schedules', 0);

        $response = $this->post('/admin/movies/'. $this->movieId .'/schedules/store', [
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time_date' => $startTime->format('Y-m-d'),
            'start_time_time' => $startTime->format('H:i'),
            'end_time_date' => $endTime->addHour()->format('Y-m-d'),
            'end_time_time' => $endTime->addHour()->format('H:i'),
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('schedules', 1);

        $response = $this->post('/admin/movies/'. $this->movieId .'/schedules/store', [
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId2,
            'start_time_date' => $startTime->format('Y-m-d'),
            'start_time_time' => $startTime->format('H:i'),
            'end_time_date' => $endTime->addHour()->format('Y-m-d'),
            'end_time_time' => $endTime->addHour()->format('H:i'),
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('schedules', 2);
    }

    public function test同一スクリーンで時間帯が重なるスケジュールにバリデーションが設定されているか() : void
    {
        $startTime1 = new Carbon('2021-01-01 10:00:00');
        $endTime1 = new Carbon('2021-01-01 12:00:00');
        $startTime2 = new Carbon('2021-01-01 11:00:00');
        $endTime2 = new Carbon('2021-01-01 13:00:00');

        $this->assertDatabaseCount('schedules', 0);

        $response = $this->post('/admin/movies/'. $this->movieId .'/schedules/store', [
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time_date' => $startTime1->format('Y-m-d'),
            'start_time_time' => $startTime1->format('H:i'),
            'end_time_date' => $endTime1->format('Y-m-d'),
            'end_time_time' => $endTime1->format('H:i'),
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount('schedules', 1);

        $response = $this->post('/admin/movies/'. $this->movieId .'/schedules/store', [
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time_date' => $startTime2->format('Y-m-d'),
            'start_time_time' => $startTime2->format('H:i'),
            'end_time_date' => $endTime2->format('Y-m-d'),
            'end_time_time' => $endTime2->format('H:i'),
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
        $this->assertDatabaseCount('schedules', 1);
    }

    public function testスケジュールが更新できるか() : void
    {
        $startTime = new Carbon('2021-01-01 10:00:00');
        $endTime = new Carbon('2021-01-01 12:00:00');

        $schedule = Schedule::create([
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        $this->assertDatabaseCount('schedules', 1);

        $response = $this->patch('/admin/schedules/'. $schedule->id .'/update', [
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time_date' => $startTime->format('Y-m-d'),
            'start_time_time' => $startTime->format('H:i'),
            'end_time_date' => $endTime->addHour()->format('Y-m-d'),
            'end_time_time' => $endTime->addHour()->format('H:i'),
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount('schedules', 1);
    }

    public function test更新時にスケジュールが重複している場合にバリデーションが設定されているか() : void
    {
        $startTime1 = new Carbon('2021-01-01 10:00:00');
        $endTime1 = new Carbon('2021-01-01 12:00:00');
        $startTime2 = new Carbon('2021-01-01 12:00:00');
        $endTime2 = new Carbon('2021-01-01 14:00:00');

        $schedule1 = Schedule::create([
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time' => $startTime1,
            'end_time' => $endTime1,
        ]);

        $this->assertDatabaseCount('schedules', 1);

        $schedule2 = Schedule::create([
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time' => $startTime2,
            'end_time' => $endTime2,
        ]);

        $this->assertDatabaseCount('schedules', 2);

        $response = $this->patch('/admin/schedules/'. $schedule2->id .'/update', [
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time_date' => $startTime1->format('Y-m-d'),
            'start_time_time' => $startTime1->format('H:i'),
            'end_time_date' => $endTime1->format('Y-m-d'),
            'end_time_time' => $endTime1->format('H:i'),
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('schedules', 2);

        $response->assertSessionHasErrors();
    }

    public function test同じ時間帯のスケジュールであっても、スクリーンが別であれば同じ席を予約できるか() : void
    {
        $startTime = new Carbon('2021-01-01 10:00:00');
        $endTime = new Carbon('2021-01-01 12:00:00');

        $schedule1 = Schedule::create([
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        $schedule2 = Schedule::create([
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId2,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        $this->assertDatabaseCount('schedules', 2);

        $response = $this->post('/reservations/store', [
            'schedule_id' => $schedule1->id,
            'sheet_id' => $this->sheetId,
            'name' => '名前',
            'email' => 'sample@techbowl.com',
            'date' => $startTime->format('Y-m-d'),
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $response = $this->post('/reservations/store', [
            'schedule_id' => $schedule2->id,
            'sheet_id' => $this->sheetId,
            'name' => '名前',
            'email' => 'sample@techbowl.com',
            'date' => $startTime->format('Y-m-d'),
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertStatus(302);

        $this->assertDatabaseCount('reservations', 2);
    }

    public function test同じ時間帯のスケジュールで同じスクリーンであれば同じ席を予約できないか() : void
    {
        $startTime = new Carbon('2021-01-01 10:00:00');
        $endTime = new Carbon('2021-01-01 12:00:00');

        $schedule = Schedule::create([
            'movie_id' => $this->movieId,
            'screen_id' => $this->screenId,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        $this->assertDatabaseCount('schedules', 1);

        $response = $this->post('/reservations/store', [
            'schedule_id' => $schedule->id,
            'sheet_id' => $this->sheetId,
            'name' => '名前',
            'email' => 'sample@techbowl.com',
            'date' => $startTime->format('Y-m-d'),
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $response = $this->post('/reservations/store', [
            'schedule_id' => $schedule->id,
            'sheet_id' => $this->sheetId,
            'name' => '名前',
            'email' => 'sample@techbowl.com',
            'date' => $startTime->format('Y-m-d'),
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseCount('reservations', 1);

    }

}