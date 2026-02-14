@extends('layouts.admin')

@section('title', 'Gestion des Compétences')

@push('styles')
<style>
    .skills-admin-container {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .stats-badge {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
    }

    .btn-add-category,
    .btn-add-skill {
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
    }

    .btn-add-category {
        background: linear-gradient(135deg, var(--secondary), #00E5D0);
        color: white;
    }

    .btn-add-skill {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
    }

    .category-section {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .category-section:hover {
        border-color: var(--primary);
    }

    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--dark-border);
    }

    .category-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .category-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .category-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .category-count {
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    .category-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid var(--dark-border);
        background: transparent;
        color: var(--text-secondary);
    }

    .btn-icon:hover {
        background: var(--dark-bg);
        border-color: var(--primary);
        color: var(--primary);
    }

    .btn-icon.delete:hover {
        border-color: var(--danger);
        color: var(--danger);
    }

    .skills-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .skill-item {
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        cursor: move;
    }

    .skill-item:hover {
        border-color: var(--primary);
        transform: translateX(5px);
    }

    .skill-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.8rem;
    }

    .skill-name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .skill-level-badge {
        padding: 0.3rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-light);
        background: rgba(108, 92, 231, 0.1);
    }

    .skill-bar {
        height: 8px;
        background: var(--dark-card);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        margin-bottom: 1rem;
    }

    .skill-progress {
        height: 100%;
        border-radius: 10px;
        transition: width 1s ease-out;
    }

    .skill-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: var(--dark-card);
        border: 1px solid var(--dark-border);
        border-radius: 20px;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .modal-close {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: none;
        background: transparent;
        color: var(--text-secondary);
        font-size: 1.5rem;
    }

    .modal-close:hover {
        background: var(--dark-bg);
        color: var(--text-primary);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 0.8rem 1rem;
        background: var(--dark-bg);
        border: 1px solid var(--dark-border);
        border-radius: 10px;
        color: var(--text-primary);
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(108, 92, 231, 0.05);
    }

    .form-range {
        width: 100%;
        height: 8px;
        background: var(--dark-bg);
        border-radius: 10px;
        outline: none;
        -webkit-appearance: none;
    }

    .form-range::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        background: var(--primary);
        border-radius: 50%;
        cursor: pointer;
    }

    .level-value {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        background: rgba(108, 92, 231, 0.1);
        border-radius: 6px;
        color: var(--primary-light);
        font-weight: 600;
        margin-left: 0.5rem;
    }

    .color-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }

    .color-option {
        height: 40px;
        border-radius: 8px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .color-option:hover,
    .color-option.selected {
        border-color: white;
        transform: scale(1.05);
    }

    .btn-submit {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(108, 92, 231, 0.3);
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .alert-success {
        background: rgba(0, 212, 170, 0.1);
        border: 1px solid var(--success);
        color: var(--success);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid var(--danger);
        color: var(--danger);
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--text-secondary);
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .action-buttons {
            width: 100%;
            flex-direction: column;
        }

        .btn-add-category,
        .btn-add-skill {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="skills-admin-container">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestion des Compétences</h1>
            <div class="stats-badge">
                {{ $totalSkills }} compétence(s)
            </div>
        </div>
        <div class="action-buttons">
            <button class="btn-add-category" onclick="openCategoryModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Ajouter une Catégorie
            </button>
            <button class="btn-add-skill" onclick="openSkillModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Ajouter une Compétence
            </button>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <!-- Categories & Skills -->
    @forelse($categories as $category)
    <div class="category-section" data-category-id="{{ $category->id }}">
        <div class="category-header">
            <div class="category-info">
                <div class="category-icon" style="background: linear-gradient(135deg, {{ $category->color }});">
                    {{ $category->icon }}
                </div>
                <div>
                    <h2 class="category-name">{{ $category->name }}</h2>
                    <p class="category-count">{{ $category->skills->count() }} compétence(s)</p>
                </div>
            </div>
            <div class="category-actions">
                <button class="btn-icon" onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->icon }}', '{{ $category->color }}')">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </button>
                <form action="{{ route('admin.skill-categories.destroy', $category) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-icon delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="skills-list" id="skills-{{ $category->id }}">
            @forelse($category->skills as $skill)
            <div class="skill-item" data-skill-id="{{ $skill->id }}">
                <div class="skill-header">
                    <span class="skill-name">{{ $skill->name }}</span>
                    <span class="skill-level-badge">{{ $skill->level }}%</span>
                </div>
                <div class="skill-bar">
                    <div class="skill-progress" style="width: {{ $skill->level }}%; background: linear-gradient(90deg, {{ $category->color }});"></div>
                </div>
                <div class="skill-actions">
                    <button class="btn-icon" onclick="editSkill({{ $skill->id }}, '{{ $skill->name }}', {{ $skill->level }}, {{ $skill->skill_category_id }})">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon delete" onclick="return confirm('Êtes-vous sûr ?')">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-state-icon">📝</div>
                <p>Aucune compétence dans cette catégorie</p>
            </div>
            @endforelse
        </div>
    </div>
    @empty
    <div class="category-section">
        <div class="empty-state">
            <div class="empty-state-icon">🎯</div>
            <h3>Aucune catégorie pour le moment</h3>
            <p>Commencez par ajouter une catégorie de compétences</p>
        </div>
    </div>
    @endforelse
</div>

<!-- Modal Catégorie -->
<div class="modal-overlay" id="categoryModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="categoryModalTitle">Nouvelle Catégorie</h3>
            <button class="modal-close" onclick="closeCategoryModal()">×</button>
        </div>
        <form id="categoryForm" method="POST" action="{{ route('admin.skill-categories.store') }}">
            @csrf
            <input type="hidden" name="_method" id="categoryMethod" value="POST">

            <div class="form-group">
                <label class="form-label">Nom *</label>
                <input type="text" name="name" id="categoryName" class="form-input" placeholder="Ex: Frontend" required>
            </div>

            <div class="form-group">
                <label class="form-label">Icône (Emoji) *</label>
                <input type="text" name="icon" id="categoryIcon" class="form-input" placeholder="🎨" required maxlength="10">
            </div>

            <div class="form-group">
                <label class="form-label">Couleur du Gradient *</label>
                <div class="color-options">
                    <div class="color-option" data-color="#667EEA, #764BA2" style="background: linear-gradient(135deg, #667EEA, #764BA2);" onclick="selectColor(this)"></div>
                    <div class="color-option" data-color="#00D4AA, #00B8A9" style="background: linear-gradient(135deg, #00D4AA, #00B8A9);" onclick="selectColor(this)"></div>
                    <div class="color-option" data-color="#A29BFE, #6C5CE7" style="background: linear-gradient(135deg, #A29BFE, #6C5CE7);" onclick="selectColor(this)"></div>
                    <div class="color-option" data-color="#FFA500, #FF8B4D" style="background: linear-gradient(135deg, #FFA500, #FF8B4D);" onclick="selectColor(this)"></div>
                    <div class="color-option" data-color="#FF6B9D, #FF4757" style="background: linear-gradient(135deg, #FF6B9D, #FF4757);" onclick="selectColor(this)"></div>
                    <div class="color-option" data-color="#00D4FF, #00A8E8" style="background: linear-gradient(135deg, #00D4FF, #00A8E8);" onclick="selectColor(this)"></div>
                </div>
                <input type="hidden" name="color" id="categoryColor" required>
            </div>

            <button type="submit" class="btn-submit">Enregistrer</button>
        </form>
    </div>
</div>

<!-- Modal Compétence -->
<div class="modal-overlay" id="skillModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="skillModalTitle">Nouvelle Compétence</h3>
            <button class="modal-close" onclick="closeSkillModal()">×</button>
        </div>
        <form id="skillForm" method="POST" action="{{ route('admin.skills.store') }}">
            @csrf
            <input type="hidden" name="_method" id="skillMethod" value="POST">

            <div class="form-group">
                <label class="form-label">Nom *</label>
                <input type="text" name="name" id="skillName" class="form-input" placeholder="Ex: React.js" required>
            </div>

            <div class="form-group">
                <label class="form-label">Catégorie *</label>
                <select name="skill_category_id" id="skillCategoryId" class="form-select" required>
                    <option value="">Sélectionner une catégorie</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">
                    Niveau
                    <span class="level-value" id="skillLevelValue">50%</span>
                </label>
                <input type="range" name="level" id="skillLevel" class="form-range" min="0" max="100" value="50" oninput="updateLevelValue(this.value)">
            </div>

            <button type="submit" class="btn-submit">Enregistrer</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Category Modal Functions
    function openCategoryModal() {
        document.getElementById('categoryModal').classList.add('active');
        document.getElementById('categoryModalTitle').textContent = 'Nouvelle Catégorie';
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryMethod').value = 'POST';
        document.getElementById('categoryForm').action = '{{ route("admin.skill-categories.store") }}';
    }

    function closeCategoryModal() {
        document.getElementById('categoryModal').classList.remove('active');
    }

    function editCategory(id, name, icon, color) {
        document.getElementById('categoryModal').classList.add('active');
        document.getElementById('categoryModalTitle').textContent = 'Modifier la Catégorie';
        document.getElementById('categoryName').value = name;
        document.getElementById('categoryIcon').value = icon;
        document.getElementById('categoryColor').value = color;
        document.getElementById('categoryMethod').value = 'PUT';
        document.getElementById('categoryForm').action = `/admin/skill-categories/${id}`;

        // Select the color option
        document.querySelectorAll('.color-option').forEach(option => {
            if (option.dataset.color === color) {
                option.classList.add('selected');
            }
        });
    }

    function selectColor(element) {
        document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
        element.classList.add('selected');
        document.getElementById('categoryColor').value = element.dataset.color;
    }

    // Skill Modal Functions
    function openSkillModal() {
        document.getElementById('skillModal').classList.add('active');
        document.getElementById('skillModalTitle').textContent = 'Nouvelle Compétence';
        document.getElementById('skillForm').reset();
        document.getElementById('skillMethod').value = 'POST';
        document.getElementById('skillForm').action = '{{ route("admin.skills.store") }}';
        updateLevelValue(50);
    }

    function closeSkillModal() {
        document.getElementById('skillModal').classList.remove('active');
    }

    function editSkill(id, name, level, categoryId) {
        document.getElementById('skillModal').classList.add('active');
        document.getElementById('skillModalTitle').textContent = 'Modifier la Compétence';
        document.getElementById('skillName').value = name;
        document.getElementById('skillLevel').value = level;
        document.getElementById('skillCategoryId').value = categoryId;
        document.getElementById('skillMethod').value = 'PUT';
        document.getElementById('skillForm').action = `/admin/skills/${id}`;
        updateLevelValue(level);
    }

    function updateLevelValue(value) {
        document.getElementById('skillLevelValue').textContent = value + '%';
    }

    // Close modals on outside click
    document.getElementById('categoryModal').addEventListener('click', function(e) {
        if (e.target === this) closeCategoryModal();
    });

    document.getElementById('skillModal').addEventListener('click', function(e) {
        if (e.target === this) closeSkillModal();
    });
</script>
@endpush
@endsection
