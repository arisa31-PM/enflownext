(function () {
  "use strict";

  var wrapperClass = "enflownext-admin-fv-fields";
  var tableClass = "enflownext-admin-fv-field";
  var pcTableClass = "enflownext-admin-fv-field--pc";
  var spTableClass = "enflownext-admin-fv-field--sp";
  var pending = false;

  function getFieldTable(input) {
    return input ? input.closest(".smart-cf-field-type-image") : null;
  }

  function getFieldTableByLabel(fieldGroup, labelText) {
    var tables = fieldGroup.querySelectorAll(".smart-cf-field-type-image");

    for (var i = 0; i < tables.length; i += 1) {
      var heading = tables[i].querySelector("th");

      if (heading && heading.textContent.trim() === labelText) {
        return tables[i];
      }
    }

    return null;
  }

  function setupTopFvFields() {
    document.querySelectorAll(".smart-cf-meta-box-table").forEach(function (fieldGroup) {
      var pcInput = fieldGroup.querySelector('input[name*="[top_fv_image_pc]"]');
      var spInput = fieldGroup.querySelector('input[name*="[top_fv_image_sp]"]');
      var pcTable = getFieldTable(pcInput) || getFieldTableByLabel(fieldGroup, "PC用FV画像");
      var spTable = getFieldTable(spInput) || getFieldTableByLabel(fieldGroup, "SP用FV画像");

      if (!pcTable || !spTable) {
        return;
      }

      pcTable.classList.add(tableClass, pcTableClass);
      spTable.classList.add(tableClass, spTableClass);

      var wrapper = fieldGroup.querySelector("." + wrapperClass);

      if (!wrapper) {
        wrapper = document.createElement("div");
        wrapper.className = wrapperClass;
        fieldGroup.insertBefore(wrapper, pcTable);
      }

      if (pcTable.parentElement !== wrapper) {
        wrapper.appendChild(pcTable);
      }

      if (spTable.parentElement !== wrapper) {
        wrapper.appendChild(spTable);
      }
    });
  }

  function requestSetup() {
    if (pending) {
      return;
    }

    pending = true;

    window.requestAnimationFrame(function () {
      pending = false;
      setupTopFvFields();
    });
  }

  function initTopFvFields() {
    setupTopFvFields();

    if (!window.MutationObserver) {
      return;
    }

    var observer = new MutationObserver(requestSetup);
    observer.observe(document.body, {
      childList: true,
      subtree: true
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initTopFvFields);
  } else {
    initTopFvFields();
  }
})();
