jQuery(document).ready(function ($) {
  $(window).scroll(function () {
    var scroll = $(window).scrollTop();

    if (scroll > 0) {
      $("section.elementor-element-b099c39").hide();
      if ($(".announcments").length) {
        $(".announcments").slick("unslick");
      }
    } else {
      $("section.elementor-element-b099c39").show();
      if ($(".announcments").length) {
        $(".announcments").slick({
          autoplay: true,
          autoplaySpeed: 5000,
          dots: false,
          // autoplay: false,
          prevArrow:
            "<div type='button' class='slick-prev slick-arrow arrow-left'></div>",
          nextArrow:
            "<div type='button' class=' slick-next slick-arrow arrow-right'></div>",
          responsive: [
            {
              breakpoint: 768,
              settings: {
                arrows: false,
              },
            },
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ],
        });
      }
    }
  });

  // $("#trigger_pa_font-type").customSelect();
  $(document).on("click", function (event) {
    var target = event.target;
    var container = $(".custom-select-container");
    if (!container.is(target) && container.has(target).length == 0) {
      container.find(".custom-select-options.opened").hide();
      container
        .find(".custom-select-options.opened")
        .closest(".custom-select-container")
        .find(".custom-select-current.expanded")
        .removeClass("expanded");
      container.find(".custom-select-options.opened").removeClass("opened");
    }
  });
  $(".engraving-item .custom-select-container .custom-select-options").on(
    "click",
    function () {
      $(this).closest(".engraving-item").find("select").change();
    }
  );

  $(".engraving #message").on("change", function () {
    $(this)
      .closest(".engraving-item-edit")
      .addClass("engraving-item-edit--edited");
    if (!$("#trigger_pa_font-type").val() == "") {
      $(".button--text").text("Modify Engraving");
    }
    if ($(this).val() === "") {
      $(".button--text").text("Add Engraving");
    }
    let messeage_option = $(this).attr("data-select");
    $("#pa_your-engraving-message-selectized").click();
    $("#pa_your-engraving-message-selectized")
      .closest(".selectize-control")
      .find(".selectize-dropdown .option[data-value='" + messeage_option + "']")
      .click();
    check_to_do_engraving_finish();
    $(".engraving #edit-engraving .mock--edit").show();
  });

  $("#trigger_pa_font-type option").each(function () {
    let font_type = $(this).val();
    let font_family = $(this).attr("data-font-family");
    if (font_family != undefined) {
      $(this).css("font-family", font_family);
      if (
        $(
          "#trigger_pa_font-type ~ .custom-select-container .custom-select-options li[data-option='" +
            font_type +
            "']"
        ).length > 0
      ) {
        $(
          "#trigger_pa_font-type ~ .custom-select-container .custom-select-options li[data-option='" +
            font_type +
            "']"
        ).css("font-family", font_family);
      }
    }
  });
  var messageBox = document.querySelector(".engraving #message");
  if (messageBox !== null) {
    messageBox.addEventListener("input", function () {
      $(this)
        .closest(".engraving-item-edit")
        .addClass("engraving-item-edit--edited");
      let messeage_option = $(this).attr("data-select");
      $("#pa_your-engraving-message-selectized").click();
      $("#pa_your-engraving-message-selectized")
        .closest(".selectize-control")
        .find(
          ".selectize-dropdown .option[data-value='" + messeage_option + "']"
        )
        .click();
      check_to_do_engraving_finish();
      $(".engraving #edit-engraving .mock--edit").show();
      if (this.value.length <= 0) {
        $(".mock--edit").css({ display: "none" });
      } else {
        $(".mock--edit").css({ display: "block" });
      }
    });
  }
  $("select#trigger_pa_font-type").on("change", function () {
    $("#pa_font-type-selectized").click();
    $("#pa_font-type-selectized")
      .closest(".selectize-control")
      .find(".selectize-dropdown .option[data-value='" + $(this).val() + "']")
      .click();

    // $("#pa_font-type").val($(this).val());
    $(this)
      .closest(".engraving-item-edit")
      .addClass("engraving-item-edit--edited");
    let font_type = $("#trigger_pa_font-type").val();
    let font_family = $(
      "#trigger_pa_font-type option[value='" + font_type + "']"
    ).attr("data-font-family");
    if (font_family != undefined) {
      $("#trigger_pa_font-type").css("font-family", font_family);
      $("#trigger_pa_font-type option[value='" + font_type + "']").css(
        "font-family",
        font_family
      );
      $("#trigger_pa_font-type ~ .custom-select-container").css(
        "font-family",
        font_family
      );
      $(".engraving .engraving-item-edit").css("font-family", font_family);
    }
    check_to_do_engraving_finish();
  });
  $(".mock--edit").click(function (e) {
    e.preventDefault();
    $(".tab-font").find("li").removeClass("selected");
    $("input#message").val("");
    $(".text-demo").text("");
    $(".button--text").text("Add Engraving");
    $(this).hide();
  });
  function check_to_do_engraving_finish() {
    let message_val = $(".engraving #message").val();
    let font_type = $("#trigger_pa_font-type").val();
    let is_valid = true;
    if (message_val.length == 0) {
      is_valid = false;
    }
    if (!(font_type && font_type.length > 0)) {
      is_valid = false;
    }

    // do
    if (is_valid) {
      let finish_text = "";
      let maxlength = parseInt($("#message").attr("maxlength"));
      if (maxlength > 0) {
        finish_text += message_val.substr(0, maxlength);
      } else {
        finish_text += message_val;
      }
      finish_text +=
        ", " +
        $("#trigger_pa_font-type option[value='" + font_type + "']").text();
      $(".text-demo").text(finish_text);
      if (
        !$(".engraving .engraving-button").hasClass("engraving-button--edited")
      ) {
        $(".engraving .engraving-button").addClass("engraving-button--edited");
      }
      if (
        $(".engraving .engraving-item-edit").length ==
        $(".engraving .engraving-item-edit.engraving-item-edit--edited").length
      ) {
        $(".engraving .engraving-item-edit").removeClass(
          "engraving-item-edit--edited"
        );
        $(".engraving .engraving-item--canhide").toggleClass("active");
        $(".engraving .engraving-item--message").toggleClass("active"); // #70977
      }
    }
  }

  $(".engraving .engraving-button").on("click", function () {
    // $(".engraving .engraving-item-edit").removeClass("engraving-item-edit--edited");
    // $(this).closest(".engraving").find(".engraving-item--canhide").toggleClass("active");
    if ($(this).hasClass("clicked")) {
      $(".engraving-button").removeClass("clicked");
      $(".engraving-header").find("#edit-engraving").css("display", "block");
      $(".engraving-item-edit").css("display", "none");
      if (
        $("#trigger_pa_font-type").val() != "" &&
        $(".engraving-item #message").val() != ""
      ) {
        $(".button--text").text("Modify Engraving");
      }
    } else {
      $(".engraving-button").addClass("clicked");
      $(".engraving-header").find("#edit-engraving").css("display", "none");
      $(".engraving-item-edit").css("display", "block");
    }
  });

  // 16/12/20
  if ($("#billing_nationality").length > 0) {
    var billing_others_nationality = "";
    if ($("#billing_others_nationality").length > 0) {
      var billing_others_label = "";
      if ($("#billing_others_nationality").attr("data-label") != undefined) {
        billing_others_label = $("#billing_others_nationality").attr(
          "data-label"
        );
      }
      billing_others_nationality = $("#billing_others_nationality").get(0);
    }

    $("#billing_nationality").on("change", function () {
      console.log($(this).val());
      if ($(this).val() == "Others") {
        if (
          $(document).find(
            "#billing_nationality_field .woocommerce-input-wrapper .billing-others-nationality"
          ).length == 0
        ) {
          $(this)
            .closest(".woocommerce-input-wrapper")
            .append("<div class='billing-others-nationality'></div>");
          if (billing_others_label != "") {
            $(document)
              .find(
                "#billing_nationality_field .woocommerce-input-wrapper .billing-others-nationality"
              )
              .append("<span>" + billing_others_label + "</span>");
          }
          $(document)
            .find(
              "#billing_nationality_field .woocommerce-input-wrapper .billing-others-nationality"
            )
            .append(billing_others_nationality);
        }
        $(document)
          .find("#billing_nationality_field .billing-others-nationality")
          .show();
      } else {
        $(document)
          .find("#billing_nationality_field .billing-others-nationality")
          .hide();
      }
    });
    // run if billing nationality is others to show field others
    if (
      $("#billing_nationality").length > 0 &&
      $("#billing_nationality").val() == "Others"
    ) {
      $("#billing_nationality").change();
    }
  }
  if ($("#shipping_nationality").length > 0) {
    var shipping_others_nationality = "";
    if ($("#shipping_others_nationality").length > 0) {
      shipping_others_nationality = $("#shipping_others_nationality").get(0);
      $("#shipping_others_nationality").remove();
    }
    $("#shipping_nationality").on("change", function () {
      console.log($(this).val());
      if ($(this).val() == "Others") {
        if (
          $(this).closest(
            ".woocommerce-input-wrapper #shipping_others_nationality"
          ).length == 0
        ) {
          $(this)
            .closest(".woocommerce-input-wrapper")
            .append(shipping_others_nationality);
        }
        $(document)
          .find("#shipping_nationality_field .billing-others-nationality")
          .show();
      } else {
        $(document)
          .find("#shipping_nationality_field .billing-others-nationality")
          .hide();
      }
    });
    if (
      $("#shipping_nationality").length > 0 &&
      $("#shipping_nationality").val() == "Others"
    ) {
      $("#shipping_nationality").change();
    }
  }
  // end 16/12/20

  /* ------------------ add by emma ------------------- */

  var cookie_notice_accepted = localStorage.getItem("cookie_notice_accepted");
  if (!cookie_notice_accepted) {
    setTimeout(function () {
      $("#cookie-notice").removeClass("cookie-notice-hidden");
    }, 8000);
  }
  $(".accept-cookie").click(function () {
    $("#cookie-notice").addClass("cookie-notice-hidden");
    localStorage.setItem("cookie_notice_accepted", true);
  });

  // Sticky Header Menu
  var stickyScroll = 0;

  function stickyMenu() {
    const header = $(".elementor-location-header"),
      headerheight = header.height(),
      pageY = $(window).scrollTop();
    $("body").css({ "padding-top": headerheight });
    if (pageY > stickyScroll && pageY >= headerheight) {
      header.addClass("sticky-menu--hidden");
    } else {
      header.removeClass("sticky-menu--hidden");
    }

    stickyScroll = pageY;
  }

  stickyMenu();

  window.addEventListener("load", function () {
    stickyMenu();
  });

  $(window).on("scroll", function (e) {
    stickyMenu();
  });
  // if ($("ul.products").length) {
  //     $(document).ajaxComplete(function(event, xhr, settings) {
  //         if (settings.url.indexOf("_paged") != -1) {
  //             var h_header = parseInt($('.elementor-location-header').outerHeight());
  //             var offsettop = $("ul.products").offset().top - h_header - 100;
  //             jQuery('html, body').animate({
  //                 scrollTop: offsettop
  //             }, 'slow');
  //         }

  //     });
  // }

  // $(document).on('facetwp-refresh', function() {
  //     if($('.filterByWrap').length > 0) {
  //         const $top = $('.filterByWrap').offset().top;
  //         document.querySelector('html').classList.add('fast-scroll');
  //         setTimeout(function() {
  //             window.scroll(0, $top - 200);
  //         }, 100);
  //     }
  // });

  // $(document).on('facetwp-loaded', function() {
  //     document.querySelector('html').classList.remove('fast-scroll');
  // });

  // End Sticky Header Menu

  // Checkout Phone Number
  const bp = document.getElementById("billing_phone");
  const sp = document.getElementById("shipping_phone");
  const registerPhone = document.getElementById("contact");
  const checkoutPhones = [bp, sp, registerPhone];

  function createMbCtCodeSelect(el) {
    const dataWrap = document.getElementById("country-mobile-code"),
      data = JSON.parse(dataWrap.textContent),
      dataCode = JSON.parse(dataWrap.getAttribute("data-code")),
      slWrap = document.createElement("div"),
      sl = document.createElement("ul"),
      slOptionResult = document.createElement("div"),
      slRelativeWrap = document.createElement("div"),
      inputCode = document.createElement("input"),
      elId = el.getAttribute("id");

    el.parentNode.classList.add("country_code");
    slOptionResult.classList.add("country_code_result");
    slWrap.classList.add("country_code_select");
    slRelativeWrap.classList.add("relative_wrap");
    sl.classList.add("sl");
    inputCode.setAttribute("type", "hidden");
    inputCode.setAttribute("name", elId + "_customcode");

    for (var i = 0; i < data.length; ++i) {
      const slOption = document.createElement("li"),
        slOptionSpan = document.createElement("span"),
        slOptionIcon = document.createElement("span"),
        slOptionNumber = document.createElement("span");

      slOption.classList.add("sl_li");
      slOptionSpan.classList.add("sl_span");
      slOptionIcon.classList.add("sl_icon");
      slOptionNumber.classList.add("sl_number");

      slOptionSpan.textContent = data[i]["country_name"];
      slOptionNumber.textContent = "+" + data[i]["country_mobile_code"];
      slOptionIcon.textContent = "+" + data[i]["country_mobile_code"];

      if (
        elId === "billing_phone" &&
        Number(data[i]["country_mobile_code"]) === Number(dataCode.billing)
      ) {
        const cpSpan = slOptionSpan.cloneNode(true),
          cpIcon = slOptionIcon.cloneNode(true);

        slOptionResult.appendChild(cpSpan);
        slOptionResult.appendChild(cpIcon);
        inputCode.value = dataCode.billing;
        el.style.paddingLeft = dataCode.billing.length * 16 + 10 + "px";
      }

      if (
        elId === "shipping_phone" &&
        Number(data[i]["country_mobile_code"]) === Number(dataCode.shipping)
      ) {
        const cpSpan = slOptionSpan.cloneNode(true),
          cpIcon = slOptionIcon.cloneNode(true);

        slOptionResult.appendChild(cpSpan);
        slOptionResult.appendChild(cpIcon);
        inputCode.value = dataCode.shipping;
        el.style.paddingLeft = dataCode.shipping.length * 16 + 10 + "px";
      }
      if (
        elId === "contact" &&
        Number(data[i]["country_mobile_code"]) === Number(dataCode.billing)
      ) {
        const cpSpan = slOptionSpan.cloneNode(true),
          cpIcon = slOptionIcon.cloneNode(true);

        slOptionResult.appendChild(cpSpan);
        slOptionResult.appendChild(cpIcon);
        inputCode.value = dataCode.billing;
        el.style.paddingLeft = dataCode.billing.length * 16 + 10 + "px";
      }

      slOption.appendChild(slOptionIcon);
      slOption.appendChild(slOptionSpan);
      slOption.appendChild(slOptionNumber);
      sl.appendChild(slOption);
    }

    slOptionResult.appendChild(inputCode);
    slRelativeWrap.appendChild(slOptionResult);
    slRelativeWrap.appendChild(sl);
    slWrap.appendChild(slRelativeWrap);

    el.parentNode.appendChild(slWrap);
  }

  var phoneLimit = 8;

  for (var j = 0; j < checkoutPhones.length; ++j) {
    if (checkoutPhones[j] !== null) {
      // Create Country Code Select
      createMbCtCodeSelect(checkoutPhones[j]);
      checkoutPhones[j].addEventListener("input", function (e) {
        const bpValue = e.target.value,
          pr = this.parentNode,
          rs = pr.querySelector(".country_code_result"),
          num = rs.querySelector(".sl_icon");

        if (num.textContent === "+65") {
          phoneLimit = 8;
        } else {
          phoneLimit = 15;
        }
        var temp = "";

        if (isNaN(Number(bpValue))) {
          for (var i = 0; i < bpValue.length; ++i) {
            if (!isNaN(Number(bpValue[i]))) {
              temp += bpValue[i];
            }
          }
          this.value = temp;
        } else {
          if (bpValue.length >= phoneLimit) {
            for (var i = 0; i < bpValue.length; ++i) {
              if (i < phoneLimit) {
                temp += bpValue[i];
              }
            }
            this.value = temp;
          }
        }
      });
    }
  }

  const ctMbCodes = document.querySelectorAll(".sl_li");

  for (var i = 0; i < ctMbCodes.length; ++i) {
    const ctMbCode = ctMbCodes[i];
    if (ctMbCode !== null) {
      ctMbCode.addEventListener("click", function () {
        const icon = this.querySelector(".sl_icon"),
          span = this.querySelector(".sl_span"),
          number = this.querySelector(".sl_number"),
          iconSrc = icon.textContent,
          spanName = span.textContent.replace("+", ""),
          numberData = number.textContent,
          parent = this.closest(".country_code_select"),
          resultBox = parent.querySelector(".country_code_result");

        resultBox.querySelector(".sl_span").textContent = spanName;
        resultBox.querySelector(".sl_icon").textContent = numberData;
        resultBox.querySelector('input[type="hidden"]').value =
          numberData.replace("+", "");

        const parentWidth = parent.offsetWidth,
          tel = this.closest(".country_code").querySelector("input"),
          telVal = tel.value;

        tel.style.paddingLeft = parentWidth + 3 + "px";
        if (numberData === "+65" && telVal.length > 8) {
          tel.value = "";
        }

        this.parentNode.style.display = "none";
        const self = this;
        setTimeout(function () {
          self.parentNode.setAttribute("style", "");
        }, 100);
      });
    }
  }

  $(document).on("facetwp-refresh", function () {
    if ($(".filterByWrap").length > 0) {
      const $top = $(".filterByWrap").offset().top;
      document.querySelector("html").classList.add("fast-scroll");
      setTimeout(function () {
        window.scroll(0, $top - 200);
        removeImageIfHaveVideo();
      }, 100);
    }
  });

  $(document).on("facetwp-loaded", function () {
    document.querySelector("html").classList.remove("fast-scroll");
    removeImageIfHaveVideo();
  });

  // Hidden Image If Product have video
  function removeImageIfHaveVideo() {
    const wcLoopProductLink = document.querySelectorAll(
      ".woocommerce-LoopProduct-link"
    );

    for (var i = 0; i < wcLoopProductLink.length; ++i) {
      const productVideo = wcLoopProductLink[i].querySelector(
          ".woocommerce-product-gallery"
        ),
        productImg = wcLoopProductLink[i].querySelector(".first-gallery-img");

      if (productImg !== null && productVideo !== null) {
        wcLoopProductLink[i].closest("li.product").classList.add("has-video");
        productImg.remove();
        if (productVideo.querySelector("iframe") !== null) {
          productVideo.querySelector("iframe").style.height =
            productVideo.offsetWidth + "px";
        }
        if (productVideo.querySelector("video") !== null) {
          productVideo.querySelector("video").style.height =
            productVideo.offsetWidth + "px";
        }
      }
    }
  }

  removeImageIfHaveVideo();

  window.addEventListener("resize", function () {
    removeImageIfHaveVideo();
  });

  // E-Gift Card Select Type

  $("#purchasing_for").on("change", function () {
    const $value = $(this).val();
    console.log($value);
    if ($value === "for_myself") {
      $("#ywgc-recipient-name").attr("disabled", true);
      $("#ywgc-recipient-email").attr("disabled", true);
    } else {
      $("#ywgc-recipient-name").removeAttr("disabled");
      $("#ywgc-recipient-email").removeAttr("disabled");
    }
  });
  // Book apointment page
  function createEle(tag = null, classes = null) {
    if (tag === null) return;
    const ele = document.createElement(tag);
    if (classes !== "") ele.setAttribute("class", classes);

    return ele;
  }

  function createCheckboxGrroup(specifyName) {
    const ele = document.querySelectorAll(specifyName);
    if (ele.length <= 0) return;

    for (let k = 0; k < ele.length; k++) {
      // Add Checkbox
      const options = ele[k].querySelectorAll("option"),
        cbWrap = createEle("div", "gcb_wrap"),
        cbClass = "interested-viewing_cb";

      for (var i = 0; i < options.length; ++i) {
        const cb = createEle("input", cbClass),
          optionValue = options[i].value,
          optionText = options[i].textContent,
          cbLabel = createEle("label", "gcb_label");
        cbLabelSpan = createEle("span");

        cb.setAttribute("value", optionValue);
        cb.setAttribute("type", "checkbox");
        cb.setAttribute("name", "gcb_value[]");
        cbLabelSpan.textContent = optionText;

        cbLabel.appendChild(cb);
        cbLabel.appendChild(cbLabelSpan);
        cbWrap.appendChild(cbLabel);
      }
      ele[k].style.cssText = "position: absolute;";
      ele[k].classList.add("block-invisible");
      ele[k].parentNode.appendChild(cbWrap);

      // Add Checkbox Event
      const cbs = document.querySelectorAll("." + cbClass);

      for (var i = 0; i < cbs.length; ++i) {
        cbs[i].addEventListener("click", function () {
          const cbValue = this.value,
            parent = this.closest(".gcb_wrap"),
            grandParent = parent.parentNode,
            selectOptions = grandParent.querySelectorAll("option");
          if (this.checked) {
            grandParent.querySelector(
              'option[value="' + cbValue + '"]'
            ).selected = true;
          } else {
            grandParent.querySelector(
              'option[value="' + cbValue + '"]'
            ).selected = false;
          }
          ele[k].dispatchEvent(new Event("change"));
        });
      }
      ele[k].addEventListener("change", function () {
        const options = this.querySelectorAll("option");
        const checkeds = this.querySelectorAll("option:checked");
        var listVal = [];
        for (var j = 0; j < checkeds.length; ++j) {
          const checked = checkeds[j];
          listVal.push(checked.getAttribute("value"));
        }

        for (var j = 0; j < options.length; ++j) {
          if (listVal.includes(options[j].getAttribute("value"))) {
            options[j].selected = true;
          } else {
            options[j].selected = false;
          }
        }

        for (var j = 0; j < cbs.length; ++j) {
          if (listVal.includes(cbs[j].value)) {
            cbs[j].checked = true;
          } else {
            cbs[j].checked = false;
          }
        }
      });
    }
  }
  createCheckboxGrroup("#form-field-interest");

  function ctGetCookie(cname) {
    const cookieStr = decodeURIComponent(document.cookie),
      cookieArr = cookieStr.split(";"),
      name = cname + "=";

    for (var i = 0; i < cookieArr.length; i++) {
      var ckie = cookieArr[i];

      if (ckie.charAt(0) == " ") {
        ckie = ckie.substring(1);
      }

      if (ckie.indexOf(name) == 0) {
        return ckie.substring(name.length, ckie.length);
      }
    }
    return "";
  }

  const popupCookieTime = popupTime,
    popupDisplayDelay = popupDelayTime;

  function refreshPopupAfterHardReload() {
    if (hardReload === "no-cache") {
      const popups = document.querySelectorAll(".uael-modal-parent-wrapper");

      popups.forEach((popup) => {
        const modal = popup.querySelector(".uael-modal"),
          popupId = popup.getAttribute("id").replace("-overlay", ""),
          cName = "uael-modal-popup-" + popupId,
          popupHiddenCookie = ctGetCookie(`modal-hidden-time-${popupId}`),
          popupTrigger = popup.getAttribute("data-trigger-on");

        if (popupTrigger === "automatic") {
          document.cookie = `modal-hidden-time-${popupId}=`;
        }
      });
    }
  }
  var ii = 0;
  function checkPopup() {
    const popups = document.querySelectorAll(".uael-modal-parent-wrapper");

    var popupShow = [];

    popups.forEach((popup) => {
      const modal = popup.querySelector(".uael-modal"),
        popupId = popup.getAttribute("id").replace("-overlay", ""),
        cName = "uael-modal-popup-" + popupId,
        popupCookie = ctGetCookie(cName),
        popupTrigger = popup.getAttribute("data-trigger-on");

      if (popupTrigger === "automatic") {
        const popupClosed = ctGetCookie(`modal-closed-${popupId}`),
          popupHiddenTime = ctGetCookie(`modal-hidden-time-${popupId}`);

        if (!popupShow.includes(popupId)) {
          if (popupHiddenTime === "") {
            popupShow.push(popupId);
          } else {
            if (new Date(popupHiddenTime).getTime() < new Date().getTime()) {
              popupShow.push(popupId);
            }
          }
        }
      }
    });
    popupShow.forEach((id, key) => {
      const modal = document.querySelector(`#modal-${id}`);

      if (key === popupShow.length - 1) {
        setTimeout(function () {
          modal.classList.add("modal--show");
          modal.parentNode
            .querySelector(".uael-overlay")
            .classList.add("overlay--show");
          document.cookie = `modal-closed-${id}=false;`;
        }, popupDisplayDelay * 1000);
      }
    });
  }

  function popupClose() {
    const closes = document.querySelectorAll(".uael-modal-close");

    closes.forEach((button) => {
      button.addEventListener("click", function () {
        const parent = this.closest(".uael-modal-parent-wrapper"),
          id = parent.getAttribute("id").replace("-overlay", "");

        const now = new Date(),
          time = now.getTime(),
          expireTime = time + popupCookieTime * 60 * 60 * 1000;

        document.cookie = `modal-closed-${id}=true;`;
        document.cookie = `modal-hidden-time-${id}=${new Date(
          expireTime
        )}; expires=${new Date(expireTime)}`;

        this.closest(".uael-modal").classList.remove("modal--show");
        this.closest(".uael-modal-parent-wrapper")
          .querySelector(".uael-overlay")
          .classList.remove("overlay--show");
      });
    });

    const overlays = document.querySelectorAll(".uael-overlay");

    overlays.forEach((ovelay) => {
      ovelay.addEventListener("click", function (e) {
        e.preventDefault();
        const parent = this.closest(".uael-modal-parent-wrapper"),
          id = parent.getAttribute("id").replace("-overlay", "");

        const now = new Date(),
          time = now.getTime(),
          expireTime = time + popupCookieTime * 1000;

        document.cookie = `modal-closed-${id}=true;`;
        document.cookie = `modal-hidden-time-${id}=${new Date(
          expireTime
        )}; expires=${new Date(expireTime)}`;

        this.closest(".uael-modal-parent-wrapper")
          .querySelector(".uael-modal")
          .classList.remove("modal--show");
        this.classList.remove("overlay--show");
      });
    });
  }

  setTimeout(function () {
    refreshPopupAfterHardReload();
    checkPopup();

    popupClose();
  }, 200);

  // Image Hover Transition
  function createProaductsHoverEffect() {
    const imageWrap = document.querySelectorAll(".astra-shop-thumbnail-wrap");
    for (var i = 0; i < imageWrap.length; ++i) {
      const images = imageWrap[i].querySelectorAll("img");
      imageWrap[i].classList.add(`product-${images.length}-image`);
    }
  }

  createProaductsHoverEffect();

  var touched = false;

  if (window.innerWidth <= 1024) {
    touched = true;
  }

  window.addEventListener("resize", function () {
    if (window.innerWidth <= 1024) {
      touched = true;
    } else {
      touched = false;
    }
  });
  function prdContextMenu(e) {
    e.preventDefault();
  }

  function addMbHoverClass() {
    const prd = document.querySelectorAll("li.product");
    prd.forEach((item) => {
      if (window.innerWidth < 768) {
        item.addEventListener("contextmenu", prdContextMenu, false);
      } else {
        item.removeEventListener("contextmenu", prdContextMenu, false);
      }
    });
  }
  window.addEventListener("resize", function () {
    addMbHoverClass();
  });
  function createProaductsHoverEffect() {
    const imageWrap = document.querySelectorAll(".astra-shop-thumbnail-wrap");
    for (var i = 0; i < imageWrap.length; ++i) {
      const images = imageWrap[i].querySelectorAll("img");
      imageWrap[i].classList.add(`product-${images.length}-image`);
    }
  }

  createProaductsHoverEffect();

  var touched = false;

  if (window.innerWidth <= 1024) {
    touched = true;
  }

  window.addEventListener("resize", function () {
    if (window.innerWidth <= 1024) {
      touched = true;
    } else {
      touched = false;
    }

    productListMobileHover();
  });

  function productListMobileHover() {
    const prd = document.querySelectorAll("li.product");
    prd.forEach((item) => {
      if (touched) {
        item.classList.add("product-touchend");
      } else {
        item.classList.remove("product-touchend");
      }

      item.addEventListener("touchstart", function (e) {
        touched = true;
        prd.forEach((el) => {
          el.classList.remove("product-touchstart");
          el.classList.add("product-touchend");
        });
        this.classList.add("product-touchstart");
        this.classList.remove("product-touchend");
        console.log("touchstart");
      });
      // item.querySelector('.woocommerce-LoopProduct-link').addEventListener('contextmenu', function(e) {
      //     e.preventDefault();
      // });

      item.addEventListener("touchend", function (e) {
        this.classList.remove("product-touchstart");
        this.classList.add("product-touchend");

        console.log("touchend");
      });

      // item.addEventListener('contextmenu', function(e) {
      //     e.preventDefault();
      // });
      item.addEventListener(
        "click",
        function (e) {
          if (e.ctrlKey) return;
        },
        false
      );
      item.addEventListener("mouseenter", function () {
        if (!touched) {
          console.log("mouseenter" + touched);
          this.classList.remove("product-touchstart");
          this.classList.remove("product-touchend");
        }
      });
    });
    addMbHoverClass();
  }

  productListMobileHover();
  $(document).ajaxComplete(function (event, xhr, settings) {
    const regex = /action=filter_diamond_by_att/gm;
    if ((m = regex.exec(settings.data) !== null)) {
      productListMobileHover();
    }
  });

  const $store = document.querySelectorAll(
    ".elementor-field-group-store_choose"
  );

  $store.forEach((item, key) => {
    const $typeOfAppoitment = item.parentNode.querySelector(
        ".elementor-field-group-type_choose"
      ),
      $typeOfAppoitmentOptions = $typeOfAppoitment.querySelectorAll("option");

    if ($typeOfAppoitment === null) {
      item.style.display = "flex";
    } else {
      if (
        $typeOfAppoitmentOptions[0].getAttribute("value") ===
        "In-Store Consultation"
      ) {
        item.style.display = "flex";
      } else {
        item.style.display = "none";
      }
    }
  });

  $(document).on("change", "#form-field-type_choose", function (e) {
    const self = this;
    setTimeout(function () {
      if ($(self).find(":selected").val() === "In-Store Consultation") {
        $(".elementor-field-group-store_choose").css({ display: "flex" });
        $("#form-field-store_choose").prop("required", true);
      } else {
        $(".elementor-field-group-store_choose").css({ display: "none" });
        $("#form-field-store_choose").prop("required", false);
      }
    }, 200);
  });

  // Size Guide Click
  $(document).on("click", ".uael-modal-action", function (e) {
    const id = this.getAttribute("data-modal");
    console.log(`modal-${id}`);
    $(`#modal-${id}`).toggleClass("modal--show");
    $(`#modal-${id}`).next().toggleClass("overlay--show");
  });

  $(document).on("click", ".tab-choose", function (e) {
    const tab = $(this).attr("data-tab");
    $(".tab-choose").removeClass("active");
    $(this).addClass("active");
    $(".tab-font").removeClass("active");
    $(`.tab-${tab}`).addClass("active");
  });

  $(document).on("click", ".tab-font > li", function (e) {
    e.preventDefault();
    const font = $(this).attr("data-value"),
      fontFamily = $(this).attr("data-font-family");

    $(".engraving-item--message").addClass("active");
    $(".tab-font > li").removeClass("selected");
    $(this).addClass("selected");
    $("#trigger_pa_font-type").find("option").prop("selected", false);
    $("#trigger_pa_font-type")
      .find(`option[value="${font}"]`)
      .prop("selected", true);
    $("#trigger_pa_font-type").change();
    $(".text-demo").css({
      "font-family": fontFamily,
      display: "block",
    });
  });

  function diamondProductPage() {
    var isDiamondPage = $(".single-product.product_diamond");
    if (isDiamondPage) {
      var shape = $(".diamond_pa_shapes")
        .find(".attribute-item-name")
        .text()
        .toLowerCase();
      var metalType = $("#pa_metal-type").val();
      var casing = $("#pa_casing").val();
      var productSlug = $("#product-slug").val();
      var parentProductName = $("#parent-product-name").val();
      // var productThumbnail = $('#product-thumbnail').val();

      $("#form-field-diamond_name").val(parentProductName);
      $("#form-field-diamond_slug").val(
        `${productSlug}?_dianmond_shapes=${shape}&_metal_type=${metalType}&_casing=${casing}&p_id=${$(
          ".variations_form.cart"
        ).attr("data-product_id")}`
      );
      // $('#form-field-diamond_thumbnail').val(productThumbnail);
      variationProduct();
    }
  }
  diamondProductPage();
  $(".variation_item").on("change", function () {
    if ($(this).parents(".engraving-variation-row").length === 0)
      diamondProductPage();
  });

  var diamondEmail = document.getElementById("form-field-diamond_email");
  if (diamondEmail !== null) {
    diamondEmail.addEventListener("input", function () {
      diamondProductPage();
    });
  }

  function variationProduct() {
    const variationDom = $(".variations_form");
    if (variationDom.length <= 0) return;

    const variationData = variationDom.data("product_variations"),
      sizesDom = $(".list_pa_ring-size").find(".item-att"),
      shape = $("select#pa_shapes").val(),
      metaType = $("select#pa_metal-type").val(),
      casing = $("select#pa_casing").val(),
      size = $("select#pa_ring-size").val(),
      diamondType = $("#pa_diamond-type").val();

    let sizes = [];

    for (let i = 0; i < variationData.length; i++) {
      const attrs = variationData[i].attributes;
      if (
        attrs["attribute_pa_casing"] === casing &&
        attrs["attribute_pa_metal-type"] === metaType &&
        attrs["attribute_pa_shapes"] === shape &&
        attrs["attribute_pa_ring-size"] === size &&
        attrs["attribute_pa_diamond-type"] === diamondType
      ) {
        $("#form-field-diamond_thumbnail").val(
          variationData[i].image["full_src"]
        );
      }
    }
  }

  variationProduct();

  $(window).load(function () {
    const options = $(".variation_item.not-empty");
    for (let i = 0; i < options.length; i++) {
      const firstOption = $(options[i]).find("option")[
        $(options[i]).find("option").length - 1
      ];
      $(firstOption).prop("selected", true);
      $(options[i]).val(firstOption.getAttribute("value")).trigger("change");
    }
  });

  const isAddtocart = $("#is_add_to_cart");
  if (isAddtocart.length > 0) {
    for (let key in JSON.parse(isAddtocart.val())) {
      setTimeout(() => {
        if (
          $(`.item-att[data-slug="${JSON.parse(isAddtocart.val())[key]}"]`)
            .length > 0
        ) {
          $(
            `.item-att[data-slug="${JSON.parse(isAddtocart.val())[key]}"]`
          ).click();
        } else {
          const options = $(`.variation_item`).find("option");
          options.map(function (index, item) {
            if (
              item.getAttribute("value") === JSON.parse(isAddtocart.val())[key]
            ) {
              item.setAttribute("selected", "selected");
              $(item.parentNode).trigger("change");
            }
          });
        }
      }, 1000);
    }
  }

  $(document).on("click", ".menu-button > a", function (e) {
    if (["#", ""].includes($(this).attr("href"))) {
      $(".to-apoinment").find("a").trigger("click");
    }
  });
  if ($("body.woocommerce-checkout").length) {
    $("#dob").flatpickr({
      dateFormat: "m/d/Y",
    });
  }






  function setCookie(cName, cValue, expDays) {
    document.cookie =
      cName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";

    let date = new Date();
    date.setTime(date.getTime() + expDays * 60 * 1000);
    const expires = "expires=" + date.toUTCString();
    document.cookie = cName + "=" + cValue + "; " + expires + "; path=/";
  }

  function str_replace(search, replace, subject) {
    return subject.split(search).join(replace);
  }

  /* David Lee: Open Popup */
  function gwp_close_popup() {
    $("#showGiftModal").hide().removeClass("show");
    $("body > .modal-backdrop").remove();
  }

  $(document).on("click", function (e) {
    if ($(e.target).hasClass("modal")) {
      e.preventDefault();
      gwp_close_popup();
    }
  });

  $(document).on("click", ".modal-gift-close", function (e) {
    e.preventDefault();
    gwp_close_popup();
  });

  $(document).on("click", ".alt-giftbox", function (e) {
    e.preventDefault();

    $("#showGiftModal").show().addClass("show");
    $("body").append('<div class="modal-backdrop fade show"></div>');

    if ($(".alt-single-detail-right").length > 0) {
      $(".alt-single-detail-right > .elementor-column-wrap").removeAttr(
        "style"
      );
    }
  });

  $(document).on("click", ".alt-cart-text-gift", function (e) {
    e.preventDefault();

    var href = $(this).attr("data-href");
    window.location.href = href;
  });

  /* David Lee: END Open Popup */

  /* David Lee: Filter for Mobile */
  if (typeof FWP != "undefined") {
    FWP.build_post_data = function () {
      return {
        facets: JSON.stringify(FWP.facets),
        frozen_facets: FWP.frozen_facets,
        http_params: FWP_HTTP,
        template: FWP.template,
        extras: FWP.extras,
        soft_refresh: FWP.soft_refresh ? 1 : 0,
        is_bfcache: FWP.is_bfcache ? 1 : 0,
        first_load: FWP.loaded ? 0 : 1,
        paged: FWP.paged,
      };
    };
  }

  var altFilterMobile = {
    filterSort: null,

    init: function () {
      // if( jQuery('#tpl-facewp-filter').length > 0 ) {
      //     jQuery('.alt-filter-widget').append( jQuery('#tpl-facewp-filter').html() );
      // }

      $(document).on("click", ".altm-filter-nav-col label", this.togglePopup);
      $(document).on(
        "click",
        ".altm-filter-panel-close",
        this.togglePopupClose
      );
      $(document).on("click", ".filterBy_label", this.togglePanelPrice);
      $(document).on(
        "click",
        ".altm-facewp-box .alt-label-wrap",
        this.togglePanel
      );
      $(document).on(
        "click",
        ".altm-facewp-box .alt-option:not(.disabled)",
        this.showChildPanel
      );
      $(document).on("click", ".altm-apply-filter", this.submit);

      $(document).on("click", ".altm-filter-sort-item", this.triggerSort);

      $(document).ajaxComplete(this.updatePanel);

      $(document).on("facetwp-loaded", this.faceWPLoaded);

      $(window).load(function () {
        setTimeout(function () {
          console.log("_replaceFilter");
          altFilterMobile._replaceFilter();
        }, 2000);
      });

      this.loadSortBy();
      this.scrollBar();
    },

    faceWPLoaded: function () {
      setTimeout(function () {
        jQuery(".altm-filter-panel-container").unblock();
        jQuery(".altm-apply-filter").prop("disabled", false);
        load_price_first();
      }, 100);

      if (altFilterMobile.filterSort) {
        $(".altm-filter-nav-first .fs-wrap").remove();
        $(".facetwp-dropdown.fs-hidden").removeClass("fs-hidden");

        altFilterMobile.filterSort = null;
      }

      altFilterMobile.updatePanelFunc();
      altFilterMobile.togglePopupClose();
    },

    scrollBar: function () {
      var lastScrollTop = 0,
        delta = 5;
      $(window).scroll(function () {
        if (
          $(".altm-filter-nav-col").hasClass("active") ||
          $(".alt-listing-heading").length <= 0
        ) {
          return;
        }

        var nowScrollTop = $(this).scrollTop(),
          titleText = $(".alt-listing-heading").offset().top;

        if (nowScrollTop > titleText) {
          $(".altm-filter-nav").addClass("has-scroll");
        } else {
          $(".altm-filter-nav").removeClass("has-scroll");
        }
        // if(Math.abs(lastScrollTop - nowScrollTop) >= delta){

        //     lastScrollTop = nowScrollTop;
        // }
      });
    },

    loadSortBy: function () {
      var orderby = $(".elementor-products-grid .orderby");

      var html = "";
      orderby.find("option").each(function (index) {
        var value = $(this).text(),
          name = $(this).attr("value");
        html +=
          '<div class="altm-filter-sort-item" data-value="' + name + '"><span>';
        html += value;
        html += "</span></div>";
      });

      $(".altm-filter-sort").html(html);
    },

    triggerSort: function (e) {
      e.preventDefault();

      var val = $(this).attr("data-value");

      jQuery(".altm-filter-panel-container")
        .addClass("has-filtering")
        .block({
          message: null,
          overlayCSS: {
            background: "#fff",
            opacity: 0.6,
          },
          ignoreIfBlocked: true,
        });

      altFilterMobile.filterSort = true;

      var url_obj = new URLSearchParams(window.location.search);
      url_obj.orderby = val;
      history.pushState(
        null,
        null,
        window.location.pathname + "?orderby=" + url_obj.orderby
      );
      FWP.soft_refresh = true;
      FWP.refresh();
    },

    togglePanelPrice: function (e) {
      e.preventDefault();

      var item = jQuery(this).next();
      item.toggleClass("alt-hidden");
    },

    togglePanel: function (e) {
      e.preventDefault();

      var _this = $(this);
      _this.next().toggleClass("alt-hidden");
    },

    showChildPanel: function (e) {
      e.preventDefault();

      var _this = $(this),
        val = _this.attr("data-value"),
        item = _this.closest(".facetwp-facet");

      _this.toggleClass("selected");
      var withoutEl = $(".filterByBoxes").find(
        ".facetwp-facet-" + item.attr("data-name")
      );

      withoutEl
        .find('.fs-option[data-value="' + val + '"]')
        .toggleClass("selected");

      altFilterMobile._faceWPFilterSet(item);
    },

    togglePopupClose: function (e) {
      if (e) {
        e.preventDefault();
      }

      var item = jQuery(".altm-filter-nav-col");
      item.removeClass("active");

      jQuery("html").removeClass("overflow-hidden");
    },

    togglePopup: function (e) {
      e.preventDefault();

      var item = jQuery(this).closest(".altm-filter-nav-col");
      item.toggleClass("active");

      jQuery("html").addClass("overflow-hidden");
    },

    submit: function (e) {
      e.preventDefault();

      var _this = jQuery(this);

      _this.prop("disabled", true);
      jQuery(".altm-filter-panel-container")
        .addClass("has-filtering")
        .block({
          message: null,
          overlayCSS: {
            background: "#fff",
            opacity: 0.6,
          },
          ignoreIfBlocked: true,
        });

      FWP.refresh();
      //altFilterMobile._faceWPRefresh();
    },

    updatePanel: function (event, xhr, settings) {
      if (
        typeof settings.data != "undefined" &&
        settings.data.indexOf("action=facetwp_refresh") == -1
      ) {
        return;
      }

      altFilterMobile.updatePanelFunc();
    },

    updatePanelFunc: function () {
      if ($(".altm-filter-nav-col.active").length > 0) {
        jQuery(".altm-filter-panel-container")
          .removeClass("has-filtering")
          .unblock();
        jQuery(".altm-filter-nav-col").removeClass("active");
      } else {
        setTimeout(function () {
          jQuery.each(FWP.facets, function (name, values) {
            if (values.length > 0) {
              var item = jQuery(".facetwp-facet-" + name);

              item.find(".alt-option").removeClass("selected");
              jQuery.each(values, function (i, value) {
                item
                  .find('.alt-option[data-value="' + value + '"]')
                  .addClass("selected");
              });

              item.find(".facetwp-dropdown").val(values);
            }
          });
        }, 2000);
      }

      if ($("form.woocommerce-ordering select.orderby").length > 0) {
        $("form.woocommerce-ordering select.orderby").selectize();
      }

      altFilterMobile._replaceFilter();
    },

    _faceWPFilterSet: function (el) {
      var selectedOptions = [],
        name = el.attr("data-name");
      el.find(".alt-option.selected").each(function () {
        var _val = $(this).attr("data-value");
        selectedOptions.push(_val);
      });

      if (el.find(".alt-wrap").hasClass("multiple")) {
        el.find(".facetwp-dropdown").val(selectedOptions);
        $(".facetwp-facet-" + name)
          .find(".facetwp-dropdown")
          .val(selectedOptions);
      }

      FWP.facets[name] = selectedOptions;
    },

    _replaceFilter: function () {
      if (altFilterMobile.filterSort) {
        altFilterMobile.filterSort = null;
        return;
      }

      var _html = "";
      jQuery(".altm-facewp > .altm-facewp-box").each(function () {
        var _this = $(this),
          html = _this[0].outerHTML;

        if (_this.find(".fs-options").is(":empty")) {
          _this.remove();
        } else {
          html = str_replace("fs-", "alt-", html);
          html = str_replace("facetwp-radio", "alt-radio", html);

          _html += html;
        }
      });

      jQuery(".altm-facewp").html(_html);

      jQuery(".altm-facewp > .altm-facewp-box").each(function () {
        var _this = $(this),
          newLabel = _this.attr("data-label");
        _this.find(".alt-label").html(newLabel);
      });

      altFilterMobile.togglePopupClose();
    },

    _faceWPRefresh: function (val = null) {
      FWP.refresh();
      return;
    },
  };

  altFilterMobile.init();

  /* Swatches outside single product */
  var altShopSwatches = {
    init: function () {
      $("ul.products li").each(function () {
        var el = $(this).find(".alt-colorswatches-wrapper");

        altShopSwatches.get_availability_attributes(el);

        // if( attributes ) {
        //     console.log(attributes);
        // }
      });
    },

    get_availability_attributes: function (el) {
      var availability_attributes = [];
      if (typeof el.attr("data-product_variations") != "undefined") {
        var variationData = jQuery.parseJSON(
          el.attr("data-product_variations")
        );

        if (variationData) {
          $.each(variationData, function (key, values) {
            availability_attributes.push(values.attributes);
          });

          $.each(availability_attributes, function (index, attributes) {
            $.each(attributes, function (attribute, value) {
              attribute = attribute.replace("attribute_", "");

              var itemAvailability = $(
                "#alt-colorswatches-" +
                  attribute +
                  " li#alt-colorswatches-" +
                  value +
                  "-item"
              );
              if (itemAvailability.length > 0) {
                itemAvailability.addClass("is-availability");
              }
            });
          });

          el.find(".alt-colorswatches-item").each(function (index) {
            var name = $(this).attr("data-name");

            $(this)
              .find("li:not(.is-availability)")
              .each(function (index) {
                $(this).addClass("disabled");
              });
          });
        }
      }
    },
  };

  altShopSwatches.init();

  jQuery.fn.altLazyload = function () {
    this.each(function () {
      var image = jQuery(this)[0],
        imgSrc = image.getAttribute("data-src"),
        imgSrcset = image.getAttribute("data-srcset");

      const fullImage = new Image();
      fullImage.src = imgSrc;
      fullImage.onload = function () {
        setTimeout(() => {
          if (imgSrcset) {
            image.srcset = imgSrcset;
          }

          image.src = imgSrc;
          image.classList.remove("lazy-img");
          image.removeAttribute("data-src");
          image.removeAttribute("data-srcset");
        }, 100);
      };
    });
  };

  jQuery("img.lazy-img").altLazyload();

  /* David Lee: Single Product Detail */
  var isClick = false;
  $(document).on("woocommerce_variation_has_changed", function () {
    var price = $(".woocommerce-variation-price").html();

    // if( ! isClick ) {
    //     isClick = $('.alt-single-product-price .elementor-widget-container').html();
    // }

    if ($(".alt-single-product-price").length > 0) {
      $(".alt-single-product-price .elementor-widget-container").html(price);
    } else {
      //$('.alt-single-product-price').prev('<div class="alt-single-product-price"><div class="elementor-widget-container">' + price + '</div></div>');
    }
  });

  $(document).on("click", ".alt-single-product-tab-title", function (e) {
    e.preventDefault();

    $(this).closest("li").toggleClass("active");
    $(this).next().slideToggle();
  });

  function load_price_first() {
    if ($(".tax-colour").length) {
      $(".products .product").each(function () {
        var el = $(this).find(
          ".alt-colorswatches-item-attributes ul li.selected"
        );
        trigger_attributes(el);
      });
    }
  }
  load_price_first();
  function trigger_attributes(el) {
    if (jQuery("table.variations").length > 0) {
      $(".alt-colorswatches-item").each(function () {
        var attribute = $(this).attr("data-attribute"),
          selected = $(this).find("li.selected");

        if ($(this).hasClass("alt-colorswatches-select-type")) {
          $("#" + attribute).val($(this).find("select").val());
        } else {
          if (selected.length > 0) {
            $("#" + attribute).val(selected.attr("data-name"));
          }
        }
      });

      jQuery("table.variations tr:last-child select").trigger("change");
    } else {
      var wrapper = el.closest(".alt-colorswatches-wrapper"),
        variations = wrapper.attr("data-product_variations"),
        url = wrapper.attr("data-url");

      if (typeof variations != "undefined") {
        var variation_selected = {};
        var cookie_variatons = [];
        wrapper.find(".alt-colorswatches-item").each(function () {
          var attribute = $(this).attr("data-attribute"),
            selected = $(this).find("li.selected"),
            value = null;

          if ($(this).hasClass("alt-colorswatches-select-type")) {
            value = $(this).find("select").val();
            variation_selected["attribute_" + attribute] = value;
            cookie_variatons.push(attribute + "::" + value);
          } else {
            if (selected.length > 0) {
              value = selected.attr("data-name");
              variation_selected["attribute_" + attribute] = value;
              cookie_variatons.push(attribute + "::" + value);
            }
          }
        });

        variations = jQuery.parseJSON(variations);
        var matching_variations = findMatchingVariations(
          variations,
          variation_selected
        );
        var variation = matching_variations.shift();

        if (variation) {
          var varation_slug = [];
          $.each(variation.attributes, function (index, value) {
            varation_slug.push(value);
          });
          console.log(varation_slug);

          var item = el.closest("li.type-product");
          const regex = /<span class="price">(.*)<\/span>/gm;
          let m;
          if ((m = regex.exec(variation.price_html)) !== null) {
            variation.price_html = m[1];
          }

          item.find("span.price").html(variation.price_html);
          item
            .find(".woocommerce-loop-product__link img:first-child")
            .removeAttr("srcset")
            .removeAttr("sizes")
            .attr("src", variation.gallery_images[0].archive_src);

          if (
            Object.keys(variation_selected).length ==
            wrapper.find(".alt-colorswatches-item").length
          ) {
            setCookie("product_name", wrapper.attr("data-product_name"), 60);
            setCookie("cookie_variatons", cookie_variatons.join("|"), 60);

            console.log(wrapper.attr("data-product_name"));
            url = url + "-" + varation_slug.join("-") + "/";

            //item.find("a").attr("href", url); // disable pretty_url
          }

          console.log(variation);
          console.log(Object.keys(variation.gallery_images).length);

          if (Object.keys(variation.gallery_images).length >= 1) {
            var src = variation.gallery_images[1] ?? "";
            if (src != "") {
              if (
                item.find(".woocommerce-loop-product__link img").length <= 1
              ) {
                item
                  .find(".woocommerce-loop-product__link")
                  .append(
                    '<img class="first-gallery-img" src="' +
                      variation.gallery_images[1].archive_src +
                      '" />'
                  );
              } else {
                console.log("else");
                if (
                  item.find(".woocommerce-loop-product__link > img:last-child")
                    .length > 0
                ) {
                  console.log(123);
                  item
                    .find(".woocommerce-loop-product__link > img:last-child")
                    .show()
                    .removeAttr("srcset")
                    .removeAttr("sizes")
                    .attr("src", variation.gallery_images[1].archive_src);
                } else {
                  console.log(456);
                  item
                    .find(
                      ".woocommerce-loop-product__link > picture:first-child source, .woocommerce-loop-product__link > picture:first-child img"
                    )
                    .show()
                    .removeAttr("srcset")
                    .removeAttr("sizes")
                    .attr("src", variation.gallery_images[0].archive_src);
                  item
                    .find(
                      ".woocommerce-loop-product__link > picture:last-child source, .woocommerce-loop-product__link > picture:last-child img"
                    )
                    .show()
                    .removeAttr("srcset")
                    .removeAttr("sizes")
                    .attr("src", variation.gallery_images[1].archive_src);
                }
              }
            }
          } else {
            item.find(".woocommerce-loop-product__link img:last-child").hide();
          }
        } else {
          var pId = parseInt(wrapper.attr("data-id"));
          //altSingleProuct.firstImages[pId
          console.log("not-found" + pId);
        }
      }
    }
  }

  function findMatchingVariations(variations, attributes) {
    var matching = [];
    for (var i = 0; i < variations.length; i++) {
      var variation = variations[i];

      if (isMatch(variation.attributes, attributes)) {
        matching.push(variation);
      }
    }
    return matching;
  }

  function isMatch(variation_attributes, attributes) {
    var match = true;
    for (var attr_name in variation_attributes) {
      if (variation_attributes.hasOwnProperty(attr_name)) {
        var val1 = variation_attributes[attr_name];
        var val2 = attributes[attr_name];
        if (
          val1 !== undefined &&
          val2 !== undefined &&
          val1.length !== 0 &&
          val2.length !== 0 &&
          val1 !== val2
        ) {
          match = false;
        }
      }
    }
    return match;
  }

  // $(document).on('mouseenter', '.alt-colorswatches-item-attributes ul li', function (e) {
  //     e.preventDefault();

  //     console.log('mouseenter');

  //     var label = $(this).attr('data-label'),
  //         item = $(this).closest('.alt-colorswatches-item');

  //     if( $(this).hasClass('disabled') ) {
  //         item.find('.alt-colorswatches-item-label .alt-colorswatches-item-label-selected').empty();
  //     }else {
  //         item.find('.alt-colorswatches-item-label .alt-colorswatches-item-label-selected').html(label);
  //     }

  // }).on('mouseout', '.alt-colorswatches-item-attributes ul li', function (e) {
  //     var item = $(this).closest('.alt-colorswatches-item');

  //     item.find('.alt-colorswatches-item-label .alt-colorswatches-item-label-selected').empty();
  //     console.log('out');
  // });

  function get_availability_attributes() {
    var attributes = [];
    if (
      typeof jQuery("form.variations_form").attr("data-product_variations") !=
      "undefined"
    ) {
      var variationData = jQuery.parseJSON(
        jQuery("form.variations_form").attr("data-product_variations")
      );

      $.each(variationData, function (key, values) {
        attributes.push(values.attributes);
      });
    }

    return attributes;
  }

  $(document).on("update_variation_values.wc-variation-form", function () {
    if ($(".alt-product-image-primary").length <= 0) {
      return;
    }
    // if( altSingleProuct.enableLazy ) {
    //     $('#alt-product-image-container .alt-product-image-primary').html( $('#tpl-product-image-loading').html() );
    // }

    var availability_attributes = get_availability_attributes();
    var empty_value = "";
    $.each(availability_attributes, function (index, attributes) {
      var i = 0;
      $.each(attributes, function (attribute, value) {
        attribute = attribute.replace("attribute_", "");
        var itemAvailability = $(
          "#alt-colorswatches-" +
            attribute +
            " li#alt-colorswatches-" +
            value +
            "-item"
        );
        if (itemAvailability.length > 0) {
          itemAvailability.addClass("is-availability");
          empty_value = "1";
        }
      });
    });
    //console.log(empty_value);
    var selectArr = [];
    if (empty_value == "") {
      jQuery("form.variations_form select").each(function () {
        var attr = $(this).attr("id");
        jQuery(this)
          .find("option.attached.enabled")
          .each(function () {
            selectArr.push($(this).val());
          });
        jQuery(this)
          .find("option")
          .each(function () {
            if ($(this).attr("selected") == "selected") {
              console.log($(this).val());
              selectArr.push($(this).val());
            }
          });
        $.each(selectArr, function (index2, value2) {
          var itemAvailability = $(
            "#alt-colorswatches-" +
              attr +
              " li#alt-colorswatches-" +
              value2 +
              "-item"
          );
          if (itemAvailability.length > 0) {
            itemAvailability.addClass("is-availability");
          }
        });
      });

      // jQuery('form.variations_form').find("select option.attached.enabled").each(function() {
      //     selectArr.push($(this).val());
      // });
      // $.each( selectArr, function( index2, value2 ) {
      //     console.log(index2+'--'+value2);
      // });
    }

    $(".alt-colorswatches-item").each(function (index) {
      var name = $(this).attr("data-name");

      $(this)
        .find("li:not(.is-availability)")
        .each(function (index) {
          $(this).addClass("disabled nnnnnnn");
        });
    });
  });

  $(document).on("click.wc-variation-form", ".reset_variations", function () {
    if ($(".alt-colorswatches-item").length <= 0) {
      return;
    }

    $(".alt-colorswatches-item-label-selected").empty();
    $(".alt-colorswatches-item-attributes li.selected").removeClass("selected");
  });

  function preload(images, _callback) {
    var index = 0;

    $.each(images, function (index, image) {
      var img = new Image();
      img.onload = function () {
        index += 1;

        if (index == images.length) {
          if (typeof _callback == "function") {
            _callback();
          }
        }
      };

      img.src = this;
    });
  }

  if ($(".alt-product-image-wrapper").hasClass("alt-product-image-one-col")) {
    callEzPlus();
  }

  function callEzPlus() {
    if ($(window).width() > 767 && jQuery().ezPlus) {
      $(".ez-plus-image").ezPlus({
        zoomType: "inner",
        cursor: "crosshair",
        borderSize: 0,
      });
    }
  }

  var altSingleProuct = {
    disableLazy: true,
    isFirstLoad: null,
    isFirstClick: 0,
    firstImages: [],
    isCLick: null,
    args: [],

    init: function () {
      this.calcualtor_cart();
      this.productImage();

      $(window).resize(function () {
        altSingleProuct.calcualtor_cart();
        //altSingleProuct.productImage(true);
      });

      $(window).scroll(function () {
        altSingleProuct.sideDetailFixed();
        altSingleProuct.addToCartFixed();
      });

      this.featuredSlider();
      this.productSwatches();
    },

    getCookie: function (name) {
      const value = `; ${document.cookie}`;
      const parts = value.split(`; ${name}=`);
      if (parts.length === 2) return parts.pop().split(";").shift();
    },

    productImageSlider: function () {
      if ($(window).width() > 767) {
        return;
      }

      $(".alt-product-image-wrapper").slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
      });
    },

    productImage: function (resize = "") {
      if ($(window).width() < 769) {
        console.log("productImage");
        altSingleProuct.productImageSlider();
      } else {
        callEzPlus();
      }

      if (!resize) {
        $(document).on("found_variation", function (e, variation) {
          if ($(".alt-product-image-primary").length <= 0) {
            return;
          }

          if (altSingleProuct.isFirstLoad) {
            var totalImage = Object.keys(
              variation.variation_gallery_images
            ).length;
            altSingleProuct.lazyLoadImage(
              totalImage,
              variation.variation_gallery_images
            );
          }
        });
      }

      $(document).on("alt_lazyload", function () {
        callEzPlus();
        altSingleProuct.productImageSlider();
      });
    },

    productSwatches: function () {
      $(document).on("found_variation", function (e, variation) {
        altSingleProuct.isFirstClick += 1;

        var item = jQuery(".alt-colorswatches-wrapper");
        if (item.length <= 0) {
          return;
        }
        var product_name = $(".alt-colorswatches-wrapper").attr(
          "data-product_name"
        );
        var varation_slug = [],
          cookie_variatons = [],
          url = item.attr("data-url");
        $.each(variation.attributes, function (index, value) {
          var attr = str_replace("attribute_", "", index);
          varation_slug.push(value);
          cookie_variatons.push(attr + "::" + value);

          $(
            "#alt-colorswatches-" +
              attr +
              " #alt-colorswatches-" +
              value +
              "-item"
          ).addClass("selected");
        });

        altSingleProuct.args["product_name"] = product_name;
        altSingleProuct.args["cookie_variatons"] = cookie_variatons.join("|");

        //if( altSingleProuct.isFirstClick > 0 ) {
        url = url + "-" + varation_slug.join("-") + "/";

        if (altSingleProuct.isCLick) {
          //history.pushState({}, "", url); // disable pretty_url
        }
      });

      $(document).on(
        "click",
        ".alt-colorswatches-item-attributes ul li:not(.disabled):not(.alt-colorswatche-disable-item)",
        function (e) {
          e.preventDefault();

          altSingleProuct.isCLick = true;

          if (altSingleProuct.isFirstClick > 0) {
            setTimeout(function () {
              altSingleProuct.isFirstClick = 0;
            }, 2000);
          } else {
            altSingleProuct.isCLick = true;

            console.log(altSingleProuct.args["url"]);
            setCookie("product_name", altSingleProuct.args["product_name"], 60);
            setCookie(
              "cookie_variatons",
              altSingleProuct.args["cookie_variatons"],
              60
            );
          }

          var availability_attributes = get_availability_attributes(),
            tplLoading = $("#tpl-product-image-loading").html(),
            _this = $(this);

          _this
            .closest(".alt-colorswatches-item")
            .find("li")
            .removeClass("selected");
          _this.addClass("selected");

          var label = _this.attr("data-label"),
            name = _this.attr("data-name"),
            item = _this.closest(".alt-colorswatches-item"),
            attribute = item.attr("data-attribute");

          altSingleProuct.isFirstLoad = true;

          item
            .find(
              ".alt-colorswatches-item-label .alt-colorswatches-item-label-selected"
            )
            .html(label);

          /* For Shop Page */
          var linkImage = _this
              .closest("li.type-product")
              .find(".woocommerce-loop-product__link"),
            firstImgEl = linkImage.find("> img:first-child"),
            lastImgEl = linkImage.find("> img:last-child").not(firstImgEl),
            imgEl = [],
            pId = parseInt(
              _this
                .closest("li.type-product")
                .find(".alt-colorswatches-wrapper")
                .attr("data-id")
            );

          imgEl.push(firstImgEl.attr("src"));

          if (lastImgEl.length > 0) {
            imgEl.push(lastImgEl.attr("src"));
          }

          if (
            !this.firstImages ||
            this.firstImages & (typeof this.firstImages[pId] == "undefined")
          ) {
            altSingleProuct.firstImages[pId] = imgEl;
          }

          trigger_attributes(_this);
        }
      );

      $(document).on(
        "change",
        ".alt-colorswatches-select-type select",
        function (e) {
          var label = $("option:selected", this).attr("data-label"),
            item = $(this).closest(".alt-colorswatches-item");

          item
            .find(
              ".alt-colorswatches-item-label .alt-colorswatches-item-label-selected"
            )
            .html(label);

          altSingleProuct.isFirstLoad = true;

          trigger_attributes($(this));
        }
      );
    },

    calcualtor_cart: function () {
      if ($(window).width() < 769) {
        return;
      }

      var _tr = $(
        ".woocommerce-cart-form > table:not(.shop_table_coupon) tbody > tr:last-child"
      );

      var w =
        _tr.find(".product-remove").outerWidth() +
        _tr.find(".product-thumbnail").outerWidth();

      $(
        ".alt-giftbox-cart-wrapper .alt-giftbox-cart-item .product-thumbnail"
      ).css({
        "flex-basis": w,
        "max-width": w,
      });

      $(".alt-giftbox-cart-wrapper .alt-giftbox-cart-item .product-name").attr(
        "style",
        "flex-basis: calc(100% - " +
          w +
          "px); max-width: calc(100% - " +
          w +
          "px);"
      );
    },

    sideDetailFixed: function () {
      // if( $('#showGiftModal').hasClass('show') || $('.alt-product-image-primary .alt-product-image-item').length <= 0 || $('.elementor-widget-alt-product-images').hasClass('elementor-hidden-desktop') ) {
      //     $('.alt-single-detail-right > .elementor-column-wrap').removeAttr('style');
      //     return;
      // }
      // $('#alt-product-image-container').addClass('has-alt-layout');
      // var scrollTop = $(window).scrollTop(),
      // startPos = $('#alt-product-image-container').offset().top,
      // endPos = $('.alt-single-product-spacer').offset().top,
      // leftSide = $('.alt-single-detail-right').offset(),
      // widthSide = $('.alt-single-detail-right').outerWidth(),
      // wWidth = $(window).width(),
      // wHeight = $(window).height();
      // var totalImage = parseInt( $('#alt-product-image-container').attr('data-total_image'));
      // if( wWidth < 768 ||  $('.waitMe_content').length > 0 ) {
      //     return;
      // }
      // var adminBar = 0;
      // if( $('#wpadminbar').length > 0 ) {
      //     adminBar += $('#wpadminbar').height();
      // }
      // if( $('#alt-single-product-terms').length > 0 ) {
      //     adminBar += 18;
      // }
      // var t = endPos - wHeight - (wHeight/2);
      // && ! isScrolledIntoView('.alt-single-product-spacer')
      // if( scrollTop > 60 && scrollTop < endPos ) {
      //     if( scrollTop < t  ) {
      //         $('.alt-single-detail-right > .elementor-column-wrap').css({
      //             'position': 'fixed',
      //             'left': leftSide.left,
      //             'top': adminBar,
      //             'width': widthSide
      //         });
      //     }else {
      //         if( isScrolledIntoView('.alt-single-product-spacer') ) {
      //             $('.alt-single-detail-right > .elementor-column-wrap').css({
      //                 'position': 'absolute',
      //                 'left': 0,
      //                 'top': 'auto',
      //                 'bottom': 0,
      //                 'width': widthSide
      //             });
      //         }else {
      //             $('.alt-single-detail-right > .elementor-column-wrap').css({
      //                 'position': 'fixed',
      //                 'left': leftSide.left,
      //                 'top': 'auto',
      //                 'bottom': 0,
      //                 'width': widthSide
      //             });
      //         }
      //     }
      // }else {
      //     $('.alt-single-detail-right .elementor-column-wrap').removeAttr('style');
      // }
    },

    /**
     * Fixed button Add to cart when scroll on mobile
     * @since 13/04/2022
     */
    addToCartFixed: function () {
      var elName = "#alt-addtocart";
      if ($(elName).length <= 0) {
        return;
      }

      var scrollTop = $(window).scrollTop(),
        w = $(window).width(),
        startPos = $(elName).offset().top;

      if (w < 768) {
        var price = $(".alt-single-product-price .price>span").html();
        if ($(".alt-single-product-price .price del").length) {
          price = $(".alt-single-product-price .price ins>span").html();
        }

        if (scrollTop > startPos && !isScrolledIntoView(elName)) {
          $(".alt-addtocart-fly")
            .addClass("fixed")
            .css("transform", "translate(0, 0)");

          altSingleProuct.appendPriceButton(price);
        } else {
          if (scrollTop < startPos && !isScrolledIntoView(elName)) {
            $(".alt-addtocart-fly")
              .addClass("fixed")
              .css("transform", "translate(0, 0)");

            altSingleProuct.appendPriceButton(price);
          } else {
            jQuery(".single_add_to_cart_button").html("Add to cart");
            $(".alt-addtocart-fly").removeClass("fixed").removeAttr("style");
          }
        }
      }
    },

    appendPriceButton: function (price) {
      var priceBtn = $(
        ".alt-addtocart-fly .single_add_to_cart_button span.price"
      );

      if (priceBtn.length <= 0 && typeof price != "undefined") {
        $(".alt-addtocart-fly .single_add_to_cart_button").append(
          '<span class="price"> - <span class="woocommerce-Price-amount amount">' +
            price +
            "</span></span>"
        );
      }
    },

    featuredSlider: function () {
      if ($(".alt-product-featured-slider").length > 0) {
        var sliderConfig = JSON.parse(
          $(".alt-product-featured-slider").attr("data-config")
        );

        $(".alt-product-featured-slider").owlCarousel({
          loop: false,
          margin: 10,
          nav: true,
          navText: [
            "<img src='" + url_sheet + "assets/images/arrow-left.svg' />",
            "<img src='" + url_sheet + "assets/images/arrow-right.svg' />",
          ],
          margin: 10,
          responsive: {
            0: {
              items: sliderConfig.slides_to_show_mobile,
            },
            767: {
              items: sliderConfig.slides_to_show_tablet,
            },
            1000: {
              items: sliderConfig.per_page,
            },
          },
          stagePadding: 80,
          onInitialized: counterItem,
          onTranslated: counterItem,
        });

        function counterItem(event) {
          var currentActive = $(event.currentTarget).find(
              ".owl-dots .owl-dot.active"
            ),
            totalItem =
              $(event.currentTarget).find(".owl-dots .owl-dot").length - 1;

          if (currentActive.index() == totalItem) {
            $(".alt-product-featured-nav-next")
              .addClass("disabled")
              .prop("disabled", true);
          } else {
            if (currentActive.index() == 0 && event.item.index == 0) {
              $(".alt-product-featured-nav-prev")
                .addClass("disabled")
                .prop("disabled", true);
            } else {
              $(".alt-product-featured-nav-prev")
                .removeClass("disabled")
                .prop("disabled", false);
              $(".alt-product-featured-nav-next")
                .removeClass("disabled")
                .prop("disabled", false);
            }
          }
        }

        $(document).on(
          "click",
          ".alt-product-featured-nav button",
          function (e) {
            e.preventDefault();

            if ($(this).hasClass("alt-product-featured-nav-prev")) {
              $(".alt-product-featured-slider-wrapper .owl-prev").trigger(
                "click"
              );
            } else {
              $(".alt-product-featured-slider-wrapper .owl-next").trigger(
                "click"
              );
            }
          }
        );
      }
    },

    /**
     * Lazy load image for 4 images
     * @since 13/04/2022
     */

    lazyLoadImage: function (totalImage, galleryImages) {
      var className = ' class="ez-plus-image"';
      if ($(window).width() < 768) {
        className = "";
      }

      var extra_class = "alt-product-image-one-col";
      if (totalImage > 3) {
        var extra_class = "alt-product-image-two-col";
      }

      var images = [];
      var html =
        '<div class="alt-product-image-wrapper ' +
        extra_class +
        ' alt-gallery-image-preloading">';
      var htmlThumb = '<div class="alt-product-image-thumbnail-wrapper">';
      $.each(galleryImages, function (i, image) {
        images.push(image.full_src);
        html += '<div class="alt-product-image-item">';
        html +=
          "<img" +
          className +
          ' src="' +
          image.full_src +
          '" data-zoom-image="' +
          image.full_src +
          '" />';
        html += "</div>";

        htmlThumb += '<div class="alt-product-image-item">';
        htmlThumb +=
          "<img" +
          className +
          ' src="' +
          image.full_src +
          '" data-zoom-image="' +
          image.full_src +
          '" />';
        htmlThumb += "</div>";
      });
      html += "</div>";
      htmlThumb += "</div>";

      preload(images, function () {
        $(".alt-product-image-wrapper").removeClass(
          "alt-gallery-image-preloading"
        );
        $(document).trigger("alt_lazyload", [images]);

        if ($(window).width() > 768) {
          $(".elementor-widget-alt-product-images")
            .removeAttr("style")
            .css(
              "min-height",
              $(".elementor-widget-alt-product-images").height()
            );
        }
      });

      $("#alt-product-image-container .alt-product-image-primary").html(html);

      if ($("#alt-product-image-thumbnail").length > 0) {
        $("#alt-product-image-container #alt-product-image-thumbnail").html(
          htmlThumb
        );
      }
    },
  };

  altSingleProuct.init();

  function isScrolledIntoView(elem) {
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return elemBottom <= docViewBottom && elemTop >= docViewTop;
  }
  /* END: Single Product Detail */












});