<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Dashboard Home
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .stat-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 20px;
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-number {
        font-size: 32px;
        font-weight: 700;
        color: #091F5B;
        margin: 10px 0 5px;
    }
    
    .stat-title {
        font-size: 14px;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .activity-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 25px;
        margin-bottom: 25px;
    }
    
    .activity-header {
        font-size: 20px;
        font-weight: 600;
        color: #091F5B;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #F3F4F6;
    }
    
    .activity-item {
        display: flex;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #F3F4F6;
    }
    
    .activity-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .icon-blue {
        background: #EBF5FF;
        color: #3B82F6;
    }
    
    .icon-green {
        background: #ECFDF5;
        color: #10B981;
    }
    
    .icon-purple {
        background: #F5F3FF;
        color: #8B5CF6;
    }
    
    .activity-content {
        flex-grow: 1;
    }
    
    .activity-title {
        font-weight: 600;
        color: #1F2937;
        margin-bottom: 5px;
    }
    
    .activity-desc {
        font-size: 14px;
        color: #6B7280;
        line-height: 1.5;
    }
    
    .activity-time {
        font-size: 12px;
        color: #9CA3AF;
        margin-top: 5px;
    }
    
    .profile-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 25px;
        text-align: center;
    }
    
    .avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 15px;
        border: 3px solid #F3F4F6;
    }
    
    .admin-name {
        font-size: 18px;
        font-weight: 600;
        color: #091F5B;
        margin-bottom: 5px;
    }
    
    .admin-role {
        color: #6B7280;
        font-size: 14px;
        margin-bottom: 20px;
    }
    
    .admin-links {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
    }
    
    .admin-link {
        display: block;
        padding: 10px 15px;
        background: #F9FAFB;
        border-radius: 8px;
        color: #4B5563;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .admin-link:hover {
        background: #F3F4F6;
        color: #091F5B;
    }
    
    .logout-link {
        color: #EF4444;
    }
    
    .logout-link:hover {
        background: #FEF2F2;
        color: #DC2626;
    }
    
    /* Ensure stat cards are same height and aligned horizontally */
    .stat-cards-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    
    @media (max-width: 768px) {
        .stat-cards-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<main >
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Left Column (3/4 width) -->
        <div class="lg:col-span-3">
            <!-- Stat Cards - Horizontal alignment -->
            <div class="stat-cards-container mb-6">
                <!-- Total Barang -->
                <div class="stat-card">
                    <div class="stat-title">Total</div>
                    <div class="stat-title">Barang</div>
                    <div class="stat-number"><?= isset($totalBarang) ? esc($totalBarang) : '1,248' ?></div>
                </div>
                
                <!-- Peminjaman Aktif -->
                <div class="stat-card">
                    <div class="stat-title">Peminjaman</div>
                    <div class="stat-title">Aktif</div>
                    <div class="stat-number"><?= isset($peminjamanAktif) ? esc($peminjamanAktif) : '0' ?></div>
                </div>
                
                <!-- Total Customers -->
                <div class="stat-card">
                    <div class="stat-title">Total</div>
                    <div class="stat-title">Customers</div>
                    <div class="stat-number"><?= isset($totalCustomer) ? esc($totalCustomer) : '248' ?></div>
                </div>
            </div>
            
            <!-- Recent Activities -->
            <div class="activity-card">
                <h2 class="activity-header">Aktivitas Terbaru</h2>
                
                <?php if (!empty($recentActivities)) : ?>
                    <?php foreach ($recentActivities as $activity) : ?>
                        <div class="activity-item">
                            <!-- Icon berdasarkan jenis aktivitas -->
                            <?php if ($activity['type'] === 'peminjaman') : ?>
                                <div class="activity-icon icon-blue">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            <?php elseif ($activity['type'] === 'barang') : ?>
                                <div class="activity-icon icon-green">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            <?php elseif ($activity['type'] === 'customer') : ?>
                                <div class="activity-icon icon-purple">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                            
                            <div class="activity-content">
                                <div class="activity-title"><?= esc($activity['title']) ?></div>
                                <div class="activity-desc"><?= esc($activity['description']) ?></div>
                                <div class="activity-time"><?= date('d M Y H:i', strtotime($activity['created_at'])) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <!-- Default activities if no data -->
                    <div class="activity-item">
                        <div class="activity-icon icon-blue">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Peminjaman baru</div>
                            <div class="activity-desc">Customer: Budi Santoso - Barang: Proyektor Epson</div>
                            <div class="activity-time">3 jam yang lalu</div>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon icon-green">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Barang baru ditambahkan</div>
                            <div class="activity-desc">Kamera Canon EOS 90D telah ditambahkan ke inventaris</div>
                            <div class="activity-time">Kemarin, 14:30</div>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon icon-purple">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Customer baru terdaftar</div>
                            <div class="activity-desc"> Jaya Abadi telah terdaftar sebagai customer baru</div>
                            <div class="activity-time">2 hari yang lalu</div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Right Column (1/4 width) -->
        
    </div>
</main>
<?= $this->endSection() ?>