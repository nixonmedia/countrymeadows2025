/**
 * ACF Relationship Field - Single Select Dropdown UI
 * 
 * Transforms an ACF Relationship field into a dropdown-like single-select interface
 * while keeping the field type as "relationship" in the backend.
 * 
 * Features:
 * - Disables drag-and-drop
 * - Enforces single selection
 * - Dropdown-like UI (collapsed/expanded)
 * - Keeps relationship field type intact
 */

(function ($) {
    'use strict';

    // Field key to target (Blog Author field)
    const FIELD_KEY = 'field_6936584f45ba3';

    /**
     * Initialize single-select dropdown behavior
     */
    function initSingleSelectDropdown($field) {
        const $relationship = $field.find('.acf-relationship');
        const $choices = $relationship.find('.choices');
        const $values = $relationship.find('.values');

        // Create dropdown behavior first (defines updateDropdownLabel)
        const updateDropdownLabel = createDropdownBehavior($field, $relationship, $choices);

        // Remove drag-and-drop functionality
        removeDragAndDrop($relationship);

        // Enforce single selection (pass updateDropdownLabel)
        enforceSingleSelection($relationship, $choices, $values, updateDropdownLabel);

        // Mark as initialized
        $field.addClass('acf-single-select-initialized');
    }

    function enforceSingleSelection($relationship, $choices, $values, updateDropdownLabel) {

        // When clicking any selectable item
        $choices.on('click', '.acf-rel-item', function () {

            // Remove existing selected items BEFORE new one is added
            const $existing = $values.find('.acf-rel-item');

            if ($existing.length > 0) {
                $existing.find('.acf-icon.-minus').trigger('click');
            }

            // Wait for ACF to finish rendering the new selected item
            setTimeout(function () {
                updateDropdownLabel();
                $relationship.removeClass('expanded');
            }, 250);
        });

        /**
         * Use MutationObserver instead of DOMSubtreeModified
         * ACF modifies DOM async, so we listen to real DOM mutations
         */
        const observer = new MutationObserver(function () {
            setTimeout(updateDropdownLabel, 150);
        });

        observer.observe($values[0], { childList: true, subtree: true });

        // Also update on remove button click
        $values.on('click', '.acf-icon.-minus', function () {
            setTimeout(updateDropdownLabel, 150);
        });
    }


    /**
     * Remove drag-and-drop functionality
     */
    function removeDragAndDrop($relationship) {
        // Destroy sortable if it exists
        const $values = $relationship.find('.values');
        if ($values.hasClass('ui-sortable')) {
            $values.sortable('destroy');
        }

        // Remove drag handles
        $relationship.find('.acf-rel-item-handle').remove();

        // Make items not draggable
        $relationship.find('.acf-rel-item').attr('draggable', 'false');
    }

    /**
     * Enforce single selection behavior
     */
    // function enforceSingleSelection($relationship, $choices, $values, updateDropdownLabel) {
    //     // Intercept when an item is being added
    //     $choices.on('click', '.acf-rel-item', function () {
    //         // Check if there's already a selected item
    //         const $existingSelected = $values.find('.acf-rel-item');

    //         // If there's already a selected item, remove it first
    //         if ($existingSelected.length > 0) {
    //             // Click the remove button on existing selected item
    //             $existingSelected.find('.acf-icon.-minus').trigger('click');
    //         }

    //         // Update label and collapse dropdown after ACF processes the selection
    //         setTimeout(function () {
    //             updateDropdownLabel();
    //             $relationship.removeClass('expanded');
    //         }, 200);
    //     });

    //     // Update dropdown label when values change
    //     $values.on('DOMSubtreeModified', function () {
    //         setTimeout(updateDropdownLabel, 50);
    //     });

    //     // Also update on ACF change event
    //     $relationship.on('change', function () {
    //         setTimeout(updateDropdownLabel, 50);
    //     });
    // }

    /**
     * Create dropdown-like behavior
     */
    function createDropdownBehavior($field, $relationship, $choices) {
        // Check if toggle already exists
        if ($relationship.find('.acf-dropdown-toggle').length > 0) {
            return function () { }; // Return empty function if already exists
        }

        // Create dropdown toggle button
        const $dropdownToggle = $('<div class="acf-dropdown-toggle">' +
            '<span class="acf-dropdown-label">Select an author...</span>' +
            '<span class="acf-dropdown-arrow">▼</span>' +
            '</div>');

        // Insert toggle before choices
        $choices.before($dropdownToggle);

        // Define update function
        // const updateDropdownLabel = function () {
        //     const $selected = $relationship.find('.values .acf-rel-item');
        //     if ($selected.length > 0) {
        //         // const selectedText = $selected.find('.acf-rel-label').text();
        //         const selectedText =
        //             $selected.find('.acf-rel-label').text() ||     // ACF 5
        //             $selected.find('.title').text() ||            // ACF 6
        //             $selected.text().trim();
        //         if (selectedText) {
        //             $dropdownToggle.find('.acf-dropdown-label').text(selectedText);
        //         }
        //     } else {
        //         $dropdownToggle.find('.acf-dropdown-label').text('Select an author...');
        //     }
        // };
        const updateDropdownLabel = function () {
            const $selected = $relationship.find('.values .acf-rel-item');

            if ($selected.length > 0) {

                const selectedText =
                    $selected.find('.acf-rel-label').text() ||
                    $selected.find('.title').text() ||
                    $selected.text().trim();

                if (selectedText) {
                    $dropdownToggle.find('.acf-dropdown-label').text(selectedText);
                    return;
                }
            }

            // Default when nothing is selected
            $dropdownToggle.find('.acf-dropdown-label').text('Select an author...');
        };


        // Toggle dropdown on click
        $dropdownToggle.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $relationship.toggleClass('expanded');
        });

        // Close dropdown when clicking outside
        $(document).on('click.acf-dropdown', function (e) {
            if (!$field.is(e.target) && $field.has(e.target).length === 0) {
                $relationship.removeClass('expanded');
            }
        });

        // Initial label update
        setTimeout(updateDropdownLabel, 200);

        // Return the update function so it can be used elsewhere
        return updateDropdownLabel;
    }

    /**
     * Initialize on ACF ready
     */
    if (typeof acf !== 'undefined') {
        // Initialize for specific field key
        acf.addAction('ready_field/key=' + FIELD_KEY, function ($field) {
            // Wait for ACF to fully load the relationship data
            setTimeout(function () {
                initSingleSelectDropdown($field);
            }, 300);
        });

        // Also initialize on append (for repeaters, etc.)
        acf.addAction('append_field/key=' + FIELD_KEY, function ($field) {
            setTimeout(function () {
                initSingleSelectDropdown($field);
            }, 300);
        });

        // Initialize after relationship field loads data
        acf.addAction('load_field/key=' + FIELD_KEY, function ($field) {
            setTimeout(function () {
                if (!$field.hasClass('acf-single-select-initialized')) {
                    initSingleSelectDropdown($field);
                }
            }, 300);
        });
    }

    /**
     * Fallback: Initialize on document ready
     */
    $(document).ready(function () {
        setTimeout(function () {
            $('.acf-field[data-key="' + FIELD_KEY + '"]').each(function () {
                const $field = $(this);
                if (!$field.hasClass('acf-single-select-initialized')) {
                    initSingleSelectDropdown($field);
                }
            });
        }, 1000);
    });

})(jQuery);
