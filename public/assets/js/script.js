

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
    directiveLookup: {},
    eventLookup: {},
  
    generateId() {
        return random_str(10);
    },

    add(directive, cb) {
         this.directiveLookup[directive] = { directive, cb };
    },
  
    init() {
              this.setupElementObserver();
              this.setupEventObserver();
    },

    runCallbacksOfEvent( event, status ) {
        
            if( !(event in this.eventLookup) ){
                return;
            }
            
            this.eventLookup[ event ]['']  =  status;

            console.log(status,this.eventLookup)
            let elements =  this.eventLookup[ event ].elements;

            elements.forEach(( element ) => {
                 this.runCallbacksOfElement( element, event, status )
            })
    },

    runCallbacksOfElement( element, event, status ) {
        var callbacks = this.getCallbacksByElement( element )
        //this.eventLookup[ event ]['status']  =  status;

        callbacks.forEach(( callback ) => {
                  callback.method( 
                        element, 
                        callback.param, 
                        status, 
                        this.eventLookup[event]['startOn']
                  );
        });
    },

    canRunCallbackOfElement ( element ) { 
          var triggers  = this.getTriggersByElement( element );
          return triggers.some( ( trigger ) => this.eventLookup[trigger].status === 'start');
    },

    isOberservableElement ( element ) {
          
          const   directives = Object.keys(this.directiveLookup);
          return  directives.some(( dir ) => 
              element.getAttribute('wr:target') && element.getAttribute( dir)
          );
    },

    getProcessableEventsByElement ( element ) {
         var triggers  = this.getTriggersByElement( element );
         return triggers.filter( ( trigger ) => this.eventLookup[trigger].status === 'start');
    },

    runProcessableEventsByElement( element ) {
       
        var events = this.getProcessableEventsByElement( element )
        events.map(( event ) => this.runCallbacksOfElement(element, event, 'start'));
    }, 

    copyInlineStyles (fromEl, toEl)  {
        toEl.style.cssText = fromEl.style.cssText;
    },

    setupElementObserver() {  

            Livewire.hook('component.init',  ({ el, component }) => {
                this.discoverElements()
            })

            Livewire.hook('morph.added', ({ el }) => {
                console.log(el); 
                if( this.isOberservableElement( el ) ){
                    el.setAttribute('wr:id', this.generateId());
                    this.registerElement( el );
                    this.runProcessableEventsByElement(el)
                }
           })

            Livewire.hook('morph.updating', ({ el, toEl, component }) => { 
                   if( this.isOberservableElement( toEl ) ){
                       this.copyInlineStyles(el, toEl);
                   }
            })
    },
    setupEventObserver(){
          Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {

                      var calls = commit.calls? commit.calls.map((c) => c.method): [];
                      
                      calls.forEach((call)=> {
                          this.eventLookup[call]['startOn'] = Date.now(); 
                          this.runCallbacksOfEvent( call, 'start'); 
                      });

                      succeed(() => {
                            queueMicrotask(() => {
                                calls.forEach((call)=> {
                                let excutiondelay = 1100 - (Date.now() - this.eventLookup[call]['startOn']) 
                                    setTimeout(() => {
                                            this.eventLookup[call]['startOn'] = 0;
                                            this.runCallbacksOfEvent( call, 'processed') 
                                    }, excutiondelay )
                                });
                            })
                      })
              })
    },

    discoverElements() {
        const elements = Array.from( document.querySelectorAll( this.getSelectQuery() ) );
        elements.forEach(( element ) => {
              element.setAttribute( 'wr:id', this.generateId())
              this.registerElement( element );
        });
    },

    registerElement( element ){
        var triggers   = this.getTriggersByElement( element );
        var callbacks  = this.getCallbacksByElement( element );
        triggers.forEach(trigger => {
            if (!(trigger in this.eventLookup)) {
                this.eventLookup[ trigger ] = {
                    name:     trigger,
                    elements: [element],
                    startOn: 0
                };
            } else {
                const nodes = this.eventLookup[ trigger ].elements;
                if( !this.isNodeInList( element, nodes) ){
                    this.eventLookup[ trigger ].elements.push( element )
                }
            }
        });
    },
    isNodeInList: function (node, nodes){
        
        return nodes.some( function( n ){
             if(n.isSameNode(node) ) {
                 return true
             } 
             if( node.getAttribute('wr:id') && 
                 n.getAttribute('wr:id')  && 
                 n.getAttribute('wr:id') === node.getAttribute('wr:id')
             ){
                return true;
             }
             return false;
        });
    },
    getSelectQuery() {
        const  escapeAttr = (attr) => attr.replace(/[:.]/g, match => `\\${match}`);
        const  directives = Object.keys(this.directiveLookup);
        const  query = directives.map(dir => `[wr\\:target][${ escapeAttr(dir)}]`).join(',');
        return query;
    },

    getCallbacksByElement(element) {

            const callbacks = [];
            Object.keys(this.directiveLookup).forEach(directive => {
                    const param = element.getAttribute(directive);
                    if (param) {
                        callbacks.push({
                            method: this.directiveLookup[directive].cb,
                            param,
                        });
                    }
            });

            return callbacks;
    },
  
    getTriggersByElement(element) {
      const attr = element.getAttribute('wr:target');
      return attr ? attr.split(',').map(tr => tr.trim()) : [];
    },
    
};
  

customDirectives.add('wr:loading.hide', function(elem, param, status, startOn){
    let params = param.trim().split(/\s+/);
    let prop   = params.at(0);
    let delay  = parseInt( params.at(1) );
    let orgDelay =  delay - (Date.now() - startOn);

    if( status === 'start'){
        return elem.style.display='none';
    }
    if( ['processed'].includes(status) ){
        return  setTimeout(() => {
                    elem.style.display=prop ;
                }, orgDelay );
    }
});
customDirectives.add('wr:loading.display', function(elem, param, status, startOn){
  
        let params = param.trim().split(/\s+/);
        let prop   = params.at(0);
        let delay  = parseInt( params.at(1) );
        let orgDelay =  delay - (Date.now() - startOn);
        if( status === 'start'){
            return elem.style.display= prop;
        }
        if( ['processed'].includes(status) ){
            return  setTimeout(() => {
                        elem.style.display = 'none';
            }, orgDelay );
        }
});

customDirectives.add('wr:loading.attr', function(elem, param, status, startOn){
    
    let params   = param.trim().split(/\s+/);
    let attr     = params.at(0);
    let delay    = parseInt( params.at(1) );
    let orgDelay =  delay - (Date.now() - startOn);

    if( status === 'start'){
        return elem.setAttribute(attr, '');
    }
    if( ['processed'].includes(status) ){
        return  setTimeout(() => {
                    elem.removeAttribute(attr);
                }, orgDelay );
    }
});

document.addEventListener('livewire:init', () => {
    customDirectives.init();
})

// document.addEventListener('livewire:init', () => {
//     // Livewire.hook('element.init', ({ el, component })=>console.log('added',el,component))
//     // Livewire.hook('morph.updated', ({ el, component })=>console.log('updated',el,component))
// })



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