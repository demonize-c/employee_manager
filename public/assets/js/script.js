

function random_str(length) {
  var result           = '';
  var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}
const customDirectives = {
       directives: [ ],

       add: function(dir, fn ) {
            this.directives[dir] = fn;
       },
       
       init: function() {
             this.deploy(this.directives);
       },

       deploy: function( directives ) {
              
              const elements = document.querySelectorAll(`[wr\\:loading]`);
              var map = {};
              elements.forEach(function( element, i){
                  let target_methods_str  = element.getAttribute('wr:target')
                  let target_methods  = target_methods_str? target_methods_str.split(',').map((method)=>method.trim()): [];
                  var data  = { element, target_methods, hooks: []};
                  Object.keys(directives ).forEach(( directive ) =>{
                        const param = element.getAttribute(directive);
                        if(param){
                          data.hooks.push({method: directives[directive], param});
                        }
                  })
                  
                  target_methods.forEach(( method )=>{
                        if(!(method in map)){
                          map[ method ] = [];
                        }
                        map[method].push(data);
                  })
              })
              Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
                      var memo_hooks = [];
                      var calls = commit.calls? commit.calls.map((c) => c.method): [];
                      calls.forEach((call)=>{
                          if(call in map){
                              let elements = map[call];
                              elements.forEach(({element, hooks})=>{
                                  hooks.forEach((hook) =>{
                                      memo_hooks.push({ element,...hook})
                                  });
                              })
                          }
                      })
                      memo_hooks.forEach((hook)=> hook.method(hook.element, hook.param, 'start'));

                      respond((params)=>{
                            memo_hooks.forEach((hook)=> hook.method(hook.element, hook.param, 'finish'));
                      })
                      
                      succeed(() => {
                            memo_hooks.forEach((hook)=> hook.method(hook.element, hook.param, 'success'));
                      })
                      
                      fail(() => {
                            memo_hooks.forEach((hook)=> hook.method(hook.element, hook.param, 'fail'));
                      })
              })
      }
}

customDirectives.add('wr:loading.hide', function(elem, param, status){
    let params = param.trim().split(/\s+/);
    let prop   = params.at(0);
    let delay  = parseInt( params.at(1) );
    if( status === 'start'){
        return elem.style.display='none';
    }
    if( ['success','fail'].includes(status) ){
        return  setTimeout(() => {
                    elem.style.display=prop ;
                }, delay);
    }
});
customDirectives.add('wr:loading.display', function(elem, param, status){
  
    let params = param.trim().split(/\s+/);
    let prop   = params.at(0);
    let delay  = parseInt( params.at(1) );

    if( status === 'start'){
        return elem.style.display= prop;
    }
    if( ['success','fail'].includes(status) ){
      return  setTimeout(() => {
                  elem.style.display='none';
              }, delay);
    }
});
customDirectives.add('wr:loading.attr', function(elem, param, status){
  let params = param.trim().split(/\s+/);
  let attr   = params.at(0);
  let delay  = parseInt( params.at(1) );

  if( status === 'start'){
      return elem.setAttribute(attr, '');
  }
  if( ['success','fail'].includes(status) ){
      return  setTimeout(() => {
                  elem.removeAttribute(attr);
               }, delay );
  }
});
document.addEventListener('livewire:init', () => {
    customDirectives.init();
})



$(document).ready( function() {
    $(document).on('click','#sidebar_toggle_btn', function(e){
           e.stopPropagation();
           $('#sidebar').toggleClass('active');
    })
    $(document).on('click','div.content', function(e){
           e.stopPropagation();
           $('#sidebar.active').removeClass('active');
     })

    
})