var appStyle = document.getElementById("app-style");
if (appStyle && appStyle.href && appStyle.href.includes("rtl.min.css")) {
    document.getElementsByTagName("html")[0].dir = "rtl";
}