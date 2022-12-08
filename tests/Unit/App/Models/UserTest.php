<?php

namespace Tests\Unit\App\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTest extends TestCase
{
    protected function model() : Model
    {
        return new User();
    }

    public function testTraits()
    {
        $traits = class_uses($this->model());    //Return Traits of class
        $traits = array_keys($traits);

        $expectedTraits = [
            HasApiTokens::class,
            HasFactory::class,
            Notifiable::class,
        ];

        $this->assertEquals($expectedTraits, $traits);
    }

    public function testFillable()
    {
        $fillable = $this->model()->getFillable();

        $expectedFillable = [
            'name',
            'email',
            'password',
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    public function testHidden()
    {
        $hidden = $this->model()->getHidden();

        $expectedHidden = [
            'password',
            'remember_token',
        ];

        $this->assertEquals($expectedHidden, $hidden);
    }

    public function testCasts()
    {
        $casts = $this->model()->getCasts();

        $expectedCasts = [
            'id' => 'string',
            'email_verified_at' => 'datetime',
            //'deleted_at' => 'datetime',
        ];

        $this->assertEquals($expectedCasts, $casts);
    }

    public function testIncrementingIsFalse()
    {
        $incrementing = $this->model()->incrementing;

        $this->assertFalse($incrementing);
    }
}
