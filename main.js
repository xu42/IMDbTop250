new Vue({

    el: 'body',
    data: {
        imdbList: null,
        torrentList: null,
        wd: '',
        itemName: null,
        torrentLiteList: null,
        torrentBtid: null,
        itemTname: null,
        alert: 'alert-info',
        available: ''
    },

    ready: function () {
        //this.availability();
        this.getImdbList();
        this.getTorrentList();
    },
    computed: {
        imdbListt: function () {
            var self = this;
            var searchArray = [];
            if (self.wd != '') {
                $.each(self.imdbList, function (index, item) {
                    if (item.name.indexOf(self.wd) != -1 || item.tname.indexOf(self.wd) != -1) {
                        searchArray.push(item);
                    }
                });
                return searchArray;
            } else {
                return self.imdbList;
            }
        }
    },
    methods: {
        getImdbList: function () {
            var self = this;
            self.$http.get('imdbList.json').then(function (response) {
                self.imdbList = response.data;
            }, function (response) {
                self.imdbList = null;
            });
        },

        getTorrentList: function () {
            var self = this;
            self.$http.get('torrentList.json').then(function (response) {
                self.torrentList = response.data;
            }, function (response) {
                self.imdbList = null;
            });
        },

        modal: function (item) {
            var self = this;
            self.itemName = item.name;
            self.itemTname = item.tname;
            self.torrentBtid = self.torrentList[item.titleid].btid;
            self.torrentLiteList = self.torrentList[item.titleid].datas;
            $('#modal-down').modal();
        },
        /*        availability: function () {
         var self = this;
         self.$http.head('http://www.bttiantang.com/', {
         timeout: 10000,
         }).then(function (response) {
         self.alert = 'alert-info';
         }, function (response) {
         self.alert = 'alert-danger';
         self.available = '种子源站当前不可用，请稍后重试';
         });
         }*/
    }

});
