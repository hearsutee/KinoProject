﻿CKEDITOR.dialog.add("scaytDialog", function (f)
{
    var g = f.scayt, k = '<p><img src="' + g.getLogo() + '" /></p><p>' + g.getLocal("version") + g.getVersion() + "</p><p>" + g.getLocal("text_copyrights") + "</p>", l = CKEDITOR.document, i = {isChanged: function ()
    {
        return null === this.newLang || this.currentLang === this.newLang ? !1 : !0
    }, currentLang: g.getLang(), newLang: null, reset: function ()
    {
        this.currentLang = g.getLang();
        this.newLang = null
    }, id: "lang"}, k = [
        {id: "options", label: g.getLocal("tab_options"), onShow: function ()
        {
        }, elements: [
            {type: "vbox",
                id: "scaytOptions", children: function ()
            {
                var a = g.getApplicationConfig(), e = [], b = {"ignore-all-caps-words": "label_allCaps", "ignore-domain-names": "label_ignoreDomainNames", "ignore-words-with-mixed-cases": "label_mixedCase", "ignore-words-with-numbers": "label_mixedWithDigits"}, d;
                for (d in a)
                {
                    var c = {type: "checkbox"};
                    c.id = d;
                    c.label = g.getLocal(b[d]);
                    e.push(c)
                }
                return e
            }(), onShow: function ()
            {
                this.getChild();
                for (var a = f.scayt, e = 0; e < this.getChild().length; e++)this.getChild()[e].setValue(a.getApplicationConfig()[this.getChild()[e].id])
            }}
        ]},
        {id: "langs", label: g.getLocal("tab_languages"), elements: [
            {id: "leftLangColumn", type: "vbox", align: "left", widths: ["100"], children: [
                {type: "html", id: "langBox", style: "overflow: hidden; white-space: normal;", html: '<form><div style="float:left;width:45%;margin-left:5px;" id="left-col-' + f.name + '"></div><div style="float:left;width:45%;margin-left:15px;" id="right-col-' + f.name + '"></div></form>', onShow: function ()
                {
                    var a = f.scayt.getLang();
                    l.getById("scaytLang_" + a).$.checked = !0
                }}
            ]}
        ]},
        {id: "dictionaries", label: g.getLocal("tab_dictionaries"),
            elements: [
                {type: "vbox", id: "rightCol_col__left", children: [
                    {type: "html", id: "dictionaryNote", html: ""},
                    {type: "text", id: "dictionaryName", label: g.getLocal("label_fieldNameDic") || "Dictionary name", onShow: function (a)
                    {
                        var e = a.sender, b = f.scayt;
                        setTimeout(function ()
                        {
                            e.getContentElement("dictionaries", "dictionaryNote").getElement().setText("");
                            null != b.getUserDictionaryName() && "" != b.getUserDictionaryName() && e.getContentElement("dictionaries", "dictionaryName").setValue(b.getUserDictionaryName())
                        }, 0)
                    }},
                    {type: "hbox",
                        id: "notExistDic", align: "left", style: "width:auto;", widths: ["50%", "50%"], children: [
                        {type: "button", id: "createDic", label: g.getLocal("btn_createDic"), title: g.getLocal("btn_createDic"), onClick: function ()
                        {
                            var a = this.getDialog(), e = j, b = f.scayt, d = a.getContentElement("dictionaries", "dictionaryName").getValue();
                            b.createUserDictionary(d, function (c)
                            {
                                c.error || e.toggleDictionaryButtons.call(a, !0);
                                c.dialog = a;
                                c.command = "create";
                                c.name = d;
                                f.fire("scaytUserDictionaryAction", c)
                            }, function (c)
                            {
                                c.dialog = a;
                                c.command = "create";
                                c.name = d;
                                f.fire("scaytUserDictionaryActionError", c)
                            })
                        }},
                        {type: "button", id: "restoreDic", label: g.getLocal("btn_restoreDic"), title: g.getLocal("btn_restoreDic"), onClick: function ()
                        {
                            var a = this.getDialog(), e = f.scayt, b = j, d = a.getContentElement("dictionaries", "dictionaryName").getValue();
                            e.restoreUserDictionary(d, function (c)
                            {
                                c.dialog = a;
                                c.error || b.toggleDictionaryButtons.call(a, !0);
                                c.command = "restore";
                                c.name = d;
                                f.fire("scaytUserDictionaryAction", c)
                            }, function (c)
                            {
                                c.dialog = a;
                                c.command = "restore";
                                c.name = d;
                                f.fire("scaytUserDictionaryActionError",
                                    c)
                            })
                        }}
                    ]},
                    {type: "hbox", id: "existDic", align: "left", style: "width:auto;", widths: ["50%", "50%"], children: [
                        {type: "button", id: "removeDic", label: g.getLocal("btn_deleteDic"), title: g.getLocal("btn_deleteDic"), onClick: function ()
                        {
                            var a = this.getDialog(), e = f.scayt, b = j, d = a.getContentElement("dictionaries", "dictionaryName"), c = d.getValue();
                            e.removeUserDictionary(c, function (e)
                            {
                                d.setValue("");
                                e.error || b.toggleDictionaryButtons.call(a, !1);
                                e.dialog = a;
                                e.command = "remove";
                                e.name = c;
                                f.fire("scaytUserDictionaryAction", e)
                            }, function (b)
                            {
                                b.dialog =
                                    a;
                                b.command = "remove";
                                b.name = c;
                                f.fire("scaytUserDictionaryActionError", b)
                            })
                        }},
                        {type: "button", id: "renameDic", label: g.getLocal("btn_renameDic"), title: g.getLocal("btn_renameDic"), onClick: function ()
                        {
                            var a = this.getDialog(), e = f.scayt, b = a.getContentElement("dictionaries", "dictionaryName").getValue();
                            e.renameUserDictionary(b, function (d)
                            {
                                d.dialog = a;
                                d.command = "rename";
                                d.name = b;
                                f.fire("scaytUserDictionaryAction", d)
                            }, function (d)
                            {
                                d.dialog = a;
                                d.command = "rename";
                                d.name = b;
                                f.fire("scaytUserDictionaryActionError", d)
                            })
                        }}
                    ]},
                    {type: "html", id: "dicInfo", html: '<div id="dic_info_editor1" style="margin:5px auto; width:95%;white-space:normal;">' + g.getLocal("text_descriptionDic") + "</div>"}
                ]}
            ]},
        {id: "about", label: g.getLocal("tab_about"), elements: [
            {type: "html", id: "about", style: "margin: 5px 5px;", html: '<div><div id="scayt_about_">' + k + "</div></div>"}
        ]}
    ];
    f.on("scaytUserDictionaryAction", function (a)
    {
        var e = a.data.dialog, b = e.getContentElement("dictionaries", "dictionaryNote").getElement(), d = a.editor.scayt, c;
        void 0 === a.data.error ? (c = d.getLocal("message_success_" +
            a.data.command + "Dic"), c = c.replace("%s", a.data.name), b.setText(c), SCAYT.$(b.$).css({color: "blue"})) : ("" === a.data.name ? b.setText(d.getLocal("message_info_emptyDic")) : (c = d.getLocal("message_error_" + a.data.command + "Dic"), c = c.replace("%s", a.data.name), b.setText(c)), SCAYT.$(b.$).css({color: "red"}), null != d.getUserDictionaryName() && "" != d.getUserDictionaryName() ? e.getContentElement("dictionaries", "dictionaryName").setValue(d.getUserDictionaryName()) : e.getContentElement("dictionaries", "dictionaryName").setValue(""))
    });
    f.on("scaytUserDictionaryActionError", function (a)
    {
        var e = a.data.dialog, b = e.getContentElement("dictionaries", "dictionaryNote").getElement(), d = a.editor.scayt, c;
        "" === a.data.name ? b.setText(d.getLocal("message_info_emptyDic")) : (c = d.getLocal("message_error_" + a.data.command + "Dic"), c = c.replace("%s", a.data.name), b.setText(c));
        SCAYT.$(b.$).css({color: "red"});
        null != d.getUserDictionaryName() && "" != d.getUserDictionaryName() ? e.getContentElement("dictionaries", "dictionaryName").setValue(d.getUserDictionaryName()) :
            e.getContentElement("dictionaries", "dictionaryName").setValue("")
    });
    var j = {title: g.getLocal("text_title"), resizable: CKEDITOR.DIALOG_RESIZE_BOTH, minWidth: 340, minHeight: 260, onLoad: function ()
    {
        if (0 != f.config.scayt_uiTabs[1])
        {
            var a = j, e = a.getLangBoxes.call(this);
            e.getParent().setStyle("white-space", "normal");
            a.renderLangList(e);
            this.definition.minWidth = this.getSize().width;
            this.resize(this.definition.minWidth, this.definition.minHeight)
        }
    }, onCancel: function ()
    {
        i.reset()
    }, onHide: function ()
    {
        f.unlockSelection()
    },
        onShow: function ()
        {
            f.fire("scaytDialogShown", this);
            if (0 != f.config.scayt_uiTabs[2])
            {
                var a = f.scayt, e = this.getContentElement("dictionaries", "dictionaryName"), b = this.getContentElement("dictionaries", "existDic").getElement().getParent(), d = this.getContentElement("dictionaries", "notExistDic").getElement().getParent();
                b.hide();
                d.hide();
                null != a.getUserDictionaryName() && "" != a.getUserDictionaryName() ? (this.getContentElement("dictionaries", "dictionaryName").setValue(a.getUserDictionaryName()), b.show()) : (e.setValue(""),
                    d.show())
            }
        }, onOk: function ()
        {
            var a = j, e = f.scayt;
            this.getContentElement("options", "scaytOptions");
            a = a.getChangedOption.call(this);
            e.commitOption({changedOptions: a})
        }, toggleDictionaryButtons: function (a)
        {
            var e = this.getContentElement("dictionaries", "existDic").getElement().getParent(), b = this.getContentElement("dictionaries", "notExistDic").getElement().getParent();
            a ? (e.show(), b.hide()) : (e.hide(), b.show())
        }, getChangedOption: function ()
        {
            var a = {};
            if (1 == f.config.scayt_uiTabs[0])for (var e = this.getContentElement("options",
                "scaytOptions").getChild(), b = 0; b < e.length; b++)e[b].isChanged() && (a[e[b].id] = e[b].getValue());
            i.isChanged() && (a[i.id] = f.config.scayt_sLang = i.currentLang = i.newLang);
            return a
        }, buildRadioInputs: function (a, e)
        {
            var b = new CKEDITOR.dom.element("div");
            CKEDITOR.document.createElement("div");
            var d = "scaytLang_" + e, c = CKEDITOR.dom.element.createFromHtml('<input id="' + d + '" type="radio"  value="' + e + '" name="scayt_lang" />'), g = new CKEDITOR.dom.element("label"), h = f.scayt;
            b.setStyles({"white-space": "normal", position: "relative"});
            c.on("click", function (a)
            {
                i.newLang = a.sender.getValue()
            });
            g.appendText(a);
            g.setAttribute("for", d);
            b.append(c);
            b.append(g);
            e === h.getLang() && (c.setAttribute("checked", !0), c.setAttribute("defaultChecked", "defaultChecked"));
            return b
        }, renderLangList: function (a)
        {
            var e = a.find("#left-col-" + f.name).getItem(0), a = a.find("#right-col-" + f.name).getItem(0), b = g.getLangList(), d = {}, c = [], i = 0, h;
            for (h in b.ltr)d[h] = b.ltr[h];
            for (h in b.rtl)d[h] = b.rtl[h];
            for (h in d)c.push([h, d[h]]);
            c.sort(function (a, b)
            {
                var c = 0;
                a[1] > b[1] ?
                    c = 1 : a[1] < b[1] && (c = -1);
                return c
            });
            d = {};
            for (b = 0; b < c.length; b++)d[c[b][0]] = c[b][1];
            c = Math.round(c.length / 2);
            for (h in d)i++, this.buildRadioInputs(d[h], h).appendTo(i <= c ? e : a)
        }, getLangBoxes: function ()
        {
            return this.getContentElement("langs", "langBox").getElement()
        }, contents: function (a, e)
        {
            var b = [], d = e.config.scayt_uiTabs;
            if (d)
            {
                for (var c in d)1 == d[c] && b.push(a[c]);
                b.push(a[a.length - 1])
            } else return a;
            return b
        }(k, f)};
    return j
});