(() => {
    'use strict';

    const searchForm = document.getElementById('recipe-filters');
    const searchInput = document.getElementById('recipe-search');
    const sortSelect = document.getElementById('recipe-sort');

    if (searchForm && searchInput) {
        let searchTimer;

        const scrollToRecipeList = () => {
            const query = new URLSearchParams(window.location.search);
            const hasActiveFilter = ['category', 'q', 'sort', 'saved', 'page']
                .some((key) => query.has(key));
            if (window.location.hash !== '#recipes' && !hasActiveFilter) return;

            const recipeSection = document.getElementById('recipes');
            if (!recipeSection) return;

            window.requestAnimationFrame(() => {
                recipeSection.scrollIntoView({
                    behavior: 'instant',
                    block: 'start',
                });
            });
        };

        scrollToRecipeList();
        window.addEventListener('hashchange', scrollToRecipeList);

        searchInput.addEventListener('input', () => {
            window.clearTimeout(searchTimer);
            searchTimer = window.setTimeout(() => searchForm.requestSubmit(), 300);
        });

        sortSelect?.addEventListener('change', () => searchForm.requestSubmit());

        document.addEventListener('keydown', (event) => {
            if (event.key === '/' && !event.ctrlKey && !event.metaKey && !event.altKey
                && !/^(INPUT|TEXTAREA|SELECT)$/.test(document.activeElement.tagName)) {
                event.preventDefault();
                searchInput.focus();
            }
        });
    }

    document.querySelectorAll('[data-confirm-delete]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!window.confirm(`Delete "${form.dataset.confirmDelete}"? This action cannot be undone.`)) {
                event.preventDefault();
            }
        });
    });

    const planner = document.querySelector('[data-meal-planner]');
    if (planner) {
        const storageKey = 'good-table-meal-plan-v1';
        const recipesNode = planner.querySelector('[data-planner-recipes]');
        const recipes = JSON.parse(recipesNode?.textContent || '[]');
        const recipeById = new Map(recipes.map((recipe) => [String(recipe.id), recipe]));
        const selects = [...planner.querySelectorAll('[data-planner-day]')];
        const list = planner.querySelector('[data-shopping-list]');
        const hint = planner.querySelector('[data-shopping-hint]');
        const count = planner.querySelector('[data-shopping-count]');
        const progress = planner.querySelector('[data-planner-progress]');
        const progressBar = planner.querySelector('[data-planner-progress-bar]');
        const feedback = planner.querySelector('[data-planner-feedback]');
        let checkedItems = new Set();

        let savedPlan;
        try {
            savedPlan = JSON.parse(window.localStorage.getItem(storageKey) || '{}');
            checkedItems = new Set(savedPlan.checked || []);
        } catch {
            savedPlan = {};
        }

        selects.forEach((select) => {
            if (savedPlan.days?.[select.dataset.plannerDay]) {
                select.value = savedPlan.days[select.dataset.plannerDay];
            }
        });

        const savePlan = () => {
            try {
                window.localStorage.setItem(storageKey, JSON.stringify({
                    days: Object.fromEntries(selects.map((select) => [select.dataset.plannerDay, select.value])),
                    checked: [...checkedItems],
                }));
            } catch {
                feedback.textContent = 'Your browser could not save this plan. It will stay here until you leave the page.';
            }
        };

        const renderShoppingList = () => {
            const ingredientMap = new Map();
            const planned = selects.filter((select) => select.value && recipeById.has(select.value));

            planned.forEach((select) => {
                const recipe = recipeById.get(select.value);
                (recipe.ingredients || []).forEach((ingredient) => {
                    const label = String(ingredient).trim();
                    if (!label) return;
                    const key = label.toLocaleLowerCase();
                    if (!ingredientMap.has(key)) ingredientMap.set(key, { label, recipes: new Set() });
                    ingredientMap.get(key).recipes.add(recipe.title);
                });
            });

            list.replaceChildren();
            const items = [...ingredientMap.entries()];
            count.textContent = String(items.length);
            hint.hidden = items.length > 0;
            progress.textContent = `${planned.length} of 7 dinners planned`;
            progressBar.style.width = `${(planned.length / 7) * 100}%`;

            items.forEach(([key, item]) => {
                const row = document.createElement('li');
                const label = document.createElement('label');
                const checkbox = document.createElement('input');
                const text = document.createElement('span');
                checkbox.type = 'checkbox';
                checkbox.checked = checkedItems.has(key);
                checkbox.addEventListener('change', () => {
                    if (checkbox.checked) checkedItems.add(key);
                    else checkedItems.delete(key);
                    savePlan();
                });
                text.textContent = item.label;
                if (item.recipes.size > 1) {
                    const note = document.createElement('small');
                    note.textContent = `Used in ${item.recipes.size} recipes`;
                    text.append(note);
                }
                label.append(checkbox, text);
                row.append(label);
                list.append(row);
            });
        };

        selects.forEach((select) => select.addEventListener('change', () => {
            feedback.textContent = '';
            savePlan();
            renderShoppingList();
        }));

        planner.querySelector('[data-planner-clear]')?.addEventListener('click', () => {
            selects.forEach((select) => { select.value = ''; });
            checkedItems.clear();
            feedback.textContent = 'Your week is clear. Pick a recipe to start again.';
            savePlan();
            renderShoppingList();
        });

        planner.querySelector('[data-print-list]')?.addEventListener('click', () => {
            document.body.classList.add('printing-shopping-list');
            window.print();
        });
        window.addEventListener('afterprint', () => document.body.classList.remove('printing-shopping-list'));

        planner.querySelector('[data-copy-list]')?.addEventListener('click', async () => {
            const lines = [...list.querySelectorAll('li')].map((row) => {
                const checkbox = row.querySelector('input');
                return `${checkbox.checked ? '[x]' : '[ ]'} ${row.querySelector('span').firstChild.textContent.trim()}`;
            });
            if (lines.length === 0) {
                feedback.textContent = 'Add a dinner to your plan first.';
                return;
            }
            try {
                await navigator.clipboard.writeText(`The Good Table shopping list\n${lines.join('\n')}`);
                feedback.textContent = 'Shopping list copied to your clipboard.';
            } catch {
                feedback.textContent = 'Clipboard access is unavailable here. Use Print list to keep a copy.';
            }
        });

        renderShoppingList();
    }

    document.querySelectorAll('[data-repeater-list]').forEach((list) => {
        const type = list.dataset.repeaterList;
        const addButton = document.querySelector(`[data-repeater-add="${type}"]`);

        if (!addButton) return;

        const updateLabels = () => {
            list.querySelectorAll('.repeater-row').forEach((row, index) => {
                const input = row.querySelector('input, textarea');
                const label = row.querySelector('label');
                const removeButton = row.querySelector('.repeater-remove');
                const labelText = type === 'ingredients' ? `Ingredient ${index + 1}` : `Instruction ${index + 1}`;

                input.id = `${type}-item-${index + 1}`;
                input.setAttribute('aria-label', labelText);
                if (label) label.htmlFor = input.id;
                removeButton.setAttribute('aria-label', `Remove ${type === 'ingredients' ? 'ingredient' : 'step'} ${index + 1}`);
            });
        };

        addButton.addEventListener('click', () => {
            const row = document.createElement('div');
            row.className = 'repeater-row';

            const input = document.createElement(type === 'ingredients' ? 'input' : 'textarea');
            input.name = `${type}[]`;
            input.required = true;
            input.maxLength = type === 'ingredients' ? 500 : 2000;
            input.placeholder = type === 'ingredients' ? 'e.g. 2 ripe avocados' : 'e.g. Preheat the oven...';

            if (type === 'instructions') input.rows = 2;

            const removeButton = document.createElement('button');
            removeButton.className = 'repeater-remove';
            removeButton.type = 'button';
            removeButton.textContent = '×';

            row.append(input, removeButton);
            list.append(row);
            updateLabels();
            input.focus();
        });

        list.addEventListener('click', (event) => {
            const removeButton = event.target.closest('.repeater-remove');
            if (!removeButton) return;

            const rows = list.querySelectorAll('.repeater-row');
            const row = removeButton.closest('.repeater-row');

            if (rows.length === 1) {
                row.querySelector('input, textarea').value = '';
                row.querySelector('input, textarea').focus();
                return;
            }

            row.remove();
            updateLabels();
        });

        updateLabels();
    });

    document.querySelectorAll('.site-header').forEach((header) => {
        const toggle = header.querySelector('.mobile-nav-toggle');
        const navigation = header.querySelector('.desktop-nav');

        if (!toggle || !navigation) return;

        const setMenuOpen = (isOpen) => {
            toggle.setAttribute('aria-expanded', String(isOpen));
            toggle.setAttribute('aria-label', isOpen ? 'Close navigation' : 'Open navigation');
            navigation.classList.toggle('is-open', isOpen);
        };

        toggle.addEventListener('click', () => {
            setMenuOpen(toggle.getAttribute('aria-expanded') !== 'true');
        });

        navigation.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => setMenuOpen(false));
        });

        document.addEventListener('click', (event) => {
            if (!header.contains(event.target)) setMenuOpen(false);
        });

        header.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                setMenuOpen(false);
                toggle.focus();
            }
        });

        window.matchMedia('(min-width: 701px)').addEventListener('change', (event) => {
            if (event.matches) setMenuOpen(false);
        });
    });
})();
