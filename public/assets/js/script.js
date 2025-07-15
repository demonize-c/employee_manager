// function toggleSidebar() {
//     const sidebar = document.getElementById('sidebar');
//     sidebar.classList.toggle('active');
// }

$(document).ready(function () {
    // $("input[type='date']").on('change', function () {
    //     const val = $(this).val(); // Format: YYYY-MM-DD

    //     if (val) {
    //         const [year, month, day] = val.split('-');
    //         const formatted = `${day}-${month}-${year}`; // Convert to DD-MM-YYYY
    //         $(this).val(formatted);
    //     } else {
    //         $(this).val('');
    //     }
    // });

    // $('.select-2').select2({
    //     placeholder: 'Select an option',
    //     height: 'resolve'
    // });

    // $(document).on('keyup','.select2-search__field', function() {
    //     // @this.set('designation', $(this).val());
    //     // alert();
    //     $wire.set('search_desig', $(this).val());
    // })
    $(function () {
        const options = [
          'Apple', 'Banana', 'Cherry', 'Date',
          'Fig', 'Grapes', 'Mango', 'Orange', 'Peach'
        ];
      
        const $wrapper  = $('#custom-select2');
        const $input    = $wrapper.find('.select2-input');
        const $dropdown = $wrapper.find('.select2-dropdown');
      
        // Render options
        function renderOptions(filter = '') {
          $dropdown.empty();
          const filtered = options.filter(opt =>
            opt.toLowerCase().includes(filter.toLowerCase())
          );
      
          if (filtered.length === 0) {
            $dropdown.append('<li class="list-group-item text-muted">No results</li>');
          } else {
            filtered.forEach(opt => {
              $dropdown.append(`<li class="list-group-item">${opt}</li>`);
            });
          }
      
          $dropdown.show();
        }
      
        // Events
        $input.on('focus input', function () {
          renderOptions($(this).val());
        });
      
        $dropdown.on('click', 'li', function () {
          const selected = $(this).text();
          $input.val(selected);
          $dropdown.hide();
      
          // ✅ You can also trigger custom events or bind Livewire value here
          console.log('Selected:', selected);
        });
      
        $(document).on('click', function (e) {
          if (!$(e.target).closest($wrapper).length) {
            $dropdown.hide();
          }
        });
      });
    
});

// document.addEventListener('livewire:load', function () {
    
// })