import $ from 'jquery';
class Search{
    //1. describe and create/initiate our object
    constructor(){
        this.addSearchHTML();
        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");
        this.resultsDiv = $('#search-overlay__results');
        this.events();
        this.isOverlayOpen = false;
        this.isSpinnerVisible = false;
        this.previousValue;
        this.typingTimer;
    }

    //2. events
    events(){
        this.openButton.on("click" , this.openOverlay.bind(this));
        this.closeButton.on("click" , this.closeOverlay.bind(this));
        $(document).on("keydown" , this.keyPressDispatcher.bind(this));
        this.searchField.on("keyup", this.typingLogic.bind(this));
    }
    


    //3. methods (functions, action...)
    typingLogic(){
        if(this.searchField.val()!= this.previousValue){
            clearTimeout(this.typingTimer);
            if(this.searchField.val()){
                if(!this.isSpinnerVisible){
                    this.resultsDiv.html('<div class="spinner-loader" ></div>');
                    this.isSpinnerVisible = true;
                }
                this.typingTimer = setTimeout( this.getResults.bind(this), 750 );
            }else{
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }

        }

        this.previousValue = this.searchField.val();
    } 

    getResults() {
        let searchTerm = this.searchField.val();

        $.when(
            $.getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + searchTerm),
            $.getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + searchTerm),
            $.getJSON(universityData.root_url + '/wp-json/wp/v2/project?search=' + searchTerm),
            $.getJSON(universityData.root_url + '/wp-json/wp/v2/event?search=' + searchTerm),
            $.getJSON(universityData.root_url + '/wp-json/wp/v2/professor?search=' + searchTerm)
        ).then((posts, pages, projects, events, professors) => {
            
            this.resultsDiv.html(`
                <div class="search-results-layout">
                    
                    <!-- COLUMN 1: General Info -->
                    <div class="search-col">
                        <h2 class="search-overlay__section-title">General Info</h2>
                        ${posts[0].length || pages[0].length ? '<ul class="search-list">' : '<p>No general information found.</p>'}
                            ${pages[0].map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                            ${posts[0].map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                        ${posts[0].length || pages[0].length ? '</ul>' : ''}
                    </div>

                    <!-- COLUMN 2: Projects & Professors -->
                    <div class="search-col">
                        <h2 class="search-overlay__section-title">Projects</h2>
                        ${projects[0].length ? '<ul class="search-list">' : '<p>No projects found.</p>'}
                            ${projects[0].map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                        ${projects[0].length ? '</ul>' : ''}

                        <h2 class="search-overlay__section-title" style="margin-top: 30px;">Professors</h2>
                        ${professors[0].length ? '<ul class="search-list">' : '<p>No professors found.</p>'}
                            ${professors[0].map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                        ${professors[0].length ? '</ul>' : ''}
                    </div>

                    <!-- COLUMN 3: Events -->
                    <div class="search-col">
                        <h2 class="search-overlay__section-title">Events</h2>
                        ${events[0].length ? '<ul class="search-list">' : '<p>No events found.</p>'}
                            ${events[0].map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
                        ${events[0].length ? '</ul>' : ''}
                    </div>

                </div>
            `);

            this.isSpinnerVisible = false;

        }, () => {
            this.resultsDiv.html('<p>Unexpected error, please try again.</p>');
            this.isSpinnerVisible = false;
        });
    }

    keyPressDispatcher(e){
        if(e.keyCode==83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')){
            this.openOverlay();
        }
        if(e.keyCode==27 && this.isOverlayOpen){
            this.closeOverlay();
        }
    }

    openOverlay(){
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
        this.searchField.val('');
        setTimeout(()=>this.searchField.focus(), 301);
        this.isOverlayOpen = true;
    }

    closeOverlay(){
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        this.isOverlayOpen = false;
    }

    addSearchHTML(){
        $("body").append(`
                <div class="search-overlay">
                    <div class="container">
                        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                        <input type="text" name="" id="search-term">
                        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                    </div>
                    <div id="search-overlay__results"></div>
                </div>
            `);
    }
}

export default Search;