<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Instansi;
use App\Models\KategoriMapel;
use App\Models\Mapel;

class MapelCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $sd;

    protected function setUp(): void
    {
        parent::setUp();

        // Create standard test data
        $this->sd = Instansi::create([
            'nama_sekolah' => 'SD Negeri 01 Poros Data',
            'tingkat' => 'SD',
        ]);

        $this->admin = User::create([
            'name' => 'Admin Test',
            'username' => 'admin_test',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'instansi_id' => $this->sd->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_mapel(): void
    {
        $response = $this->get(route('mapel.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_mapel(): void
    {
        $response = $this->actingAs($this->admin)->get(route('mapel.index'));
        $response->assertStatus(200);
        $response->assertSee('Kelola Mata Pelajaran');
    }

    public function test_admin_can_create_kategori(): void
    {
        $response = $this->actingAs($this->admin)->post(route('mapel.kategori.store'), [
            'nama_kategori' => 'Kategori Baru',
        ]);

        $response->assertRedirect(route('mapel.index'));
        $this->assertDatabaseHas('kategori_mapel', [
            'nama_kategori' => 'Kategori Baru',
            'instansi_id' => $this->sd->id,
        ]);
    }

    public function test_admin_can_create_mapel(): void
    {
        $kategori = KategoriMapel::create([
            'nama_kategori' => 'Kategori Test',
            'instansi_id' => $this->sd->id,
        ]);

        $response = $this->actingAs($this->admin)->post(route('mapel.store'), [
            'kode_mapel' => 'IND-01',
            'nama_mapel' => 'Bahasa Indonesia',
            'kategori_mapel_id' => $kategori->id,
        ]);

        $response->assertRedirect(route('mapel.index'));
        $this->assertDatabaseHas('mapel', [
            'kode_mapel' => 'IND-01',
            'nama_mapel' => 'Bahasa Indonesia',
            'kategori_mapel_id' => $kategori->id,
            'instansi_id' => $this->sd->id,
        ]);
    }

    public function test_admin_can_update_mapel(): void
    {
        $kategori = KategoriMapel::create([
            'nama_kategori' => 'Kategori Test',
            'instansi_id' => $this->sd->id,
        ]);

        $mapel = Mapel::create([
            'kode_mapel' => 'IND-01',
            'nama_mapel' => 'Bahasa Indonesia',
            'kategori_mapel_id' => $kategori->id,
            'instansi_id' => $this->sd->id,
        ]);

        $response = $this->actingAs($this->admin)->put(route('mapel.update', $mapel->id), [
            'kode_mapel' => 'IND-01-REV',
            'nama_mapel' => 'Bahasa Indonesia Revisi',
            'kategori_mapel_id' => $kategori->id,
        ]);

        $response->assertRedirect(route('mapel.index'));
        $this->assertDatabaseHas('mapel', [
            'id' => $mapel->id,
            'kode_mapel' => 'IND-01-REV',
            'nama_mapel' => 'Bahasa Indonesia Revisi',
        ]);
    }

    public function test_admin_can_delete_mapel(): void
    {
        $kategori = KategoriMapel::create([
            'nama_kategori' => 'Kategori Test',
            'instansi_id' => $this->sd->id,
        ]);

        $mapel = Mapel::create([
            'kode_mapel' => 'IND-01',
            'nama_mapel' => 'Bahasa Indonesia',
            'kategori_mapel_id' => $kategori->id,
            'instansi_id' => $this->sd->id,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('mapel.destroy', $mapel->id));

        $response->assertRedirect(route('mapel.index'));
        $this->assertDatabaseMissing('mapel', [
            'id' => $mapel->id,
        ]);
    }
}
