(function(w,n,i) {
    w[n] = {
        /* list */
        l: {
            'jquery': {
                u: '//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js',
                f: 'scripts/jquery.3.2.1.min.js'
            },
            'framework': {
                u: 'scripts/framework.js',
                d: ['jquery']
            }
        },
        
        /* load file */
        loader: function(n,l,f,d,t,h,o) {
            l = this.l;
            f = l[n];
            d = document;
            t = 'script';
            
            if (!f) return false;
            
            if (f.d && typeof f.d != 'object') f.d = [f.d];
            
            h = d.getElementsByTagName(t)[0];
            
            o = d.createElement(t);
            o.setAttribute('data-name',n);
            o.async = 1;
            o.src = f.u;
            o.onload = function() {
                window['s'].loaded(this.getAttribute('data-name'));
            };
            o.onerror = function(n,f) {
                n = this.getAttribute('data-name');
                f = window['s'].l[n];
                f.failed = true;
                
                if (f.f) {
                    f.u = f.f;
                    f.f = null;
                    
                    window['s'].loader(n);
                }
                
                this.parentNode.removeChild(this);
            };
            
            h.parentNode.insertBefore(o,h);
        },
        
        /* file loaded */
        loaded: function(n,l,o) {
            l = this.l;
            o = l[n];
            o.loaded = true;
            o.failed = null;
            
            if (!o.d) o.initiated = true;
            
            /* check if other scripts now are now ready to run */
            this.check();
        },
        
        check: function(l,i,o,v,d) {
            l = this.l;
            
            for(i in l) {
                o = l[i];
                
                /* check only delayed, not yet initiated with code to run */
                if (o.d && !o.initiated && o.init) {
                    v = true;
                    
                    for(d in o.d) {
                        d = o.d[d];
                        
                        if (!l[d] || !l[d].loaded || !l[d].initiated) v = false;
                    }
                    
                    if (v) {
                        o.initiated = true;
                        
                        for(i in o.init) o.init[i]();
                        
                        this.check();
                    }
                }
            }
        },
        
        /* file content */
        'ready': function(n,s,o) {
            o = this.l[n];
            
            if (!o) return false;
            
            if (!o.d) {
                s();
                
                return true;
            }
            
            o.init = o.init ? o.init.push(s) : [s];
        }
    };
    
    /* load files */
    for(i in w[n].l) w[n].loader(i);
})(window,'s');