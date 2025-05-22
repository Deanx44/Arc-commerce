<?php 
$page_title = "Welcome to Arcyterx Shop";
include_once __DIR__ . '/includes/header.php'; 

// Fetch homepage content
$hero_data = null;
$hero_result = $conn->query("SELECT * FROM homepage_hero WHERE id = 1 LIMIT 1");
if ($hero_result && $hero_result->num_rows > 0) {
    $hero_data = $hero_result->fetch_assoc();
}

$brands_data = [];
$brands_result = $conn->query("SELECT * FROM homepage_brands WHERE is_active = 1 ORDER BY id ASC");
if ($brands_result) {
    while ($row = $brands_result->fetch_assoc()) {
        $brands_data[] = $row;
    }
}

$reviews_data = [];
$reviews_result = $conn->query("SELECT * FROM homepage_reviews WHERE is_active = 1 ORDER BY rating DESC, id DESC LIMIT 3"); // Show top 3 reviews
if ($reviews_result) {
    while ($row = $reviews_result->fetch_assoc()) {
        $reviews_data[] = $row;
    }
}
?>

<!-- Hero Section with Enhanced UI -->
<section class="hero-section py-5 position-relative overflow-hidden">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 position-relative z-index-1">
        <?php if ($hero_data): ?>
          <h1 class="display-4 fw-bold mb-3 hero-title">
            <?php echo htmlspecialchars($hero_data['title']); ?>
          </h1>
          <p class="lead mb-4 text-secondary"><?php echo htmlspecialchars($hero_data['subtitle']); ?></p>
          <div class="mb-4 d-flex flex-wrap">
            <a href="<?php echo htmlspecialchars($hero_data['button_link']); ?>" class="btn btn-primary btn-lg me-3 px-4 rounded-pill shadow-sm">
              <?php echo htmlspecialchars($hero_data['button_text']); ?>
            </a>
            <a href="about.php" class="btn btn-outline-secondary btn-lg rounded-pill">Learn more <i class="bi bi-arrow-right ms-1"></i></a>
          </div>
        <?php else: ?>
          <h1 class="display-4 fw-bold mb-3 hero-title">
            PRECISION ENGINEERED<span class="text-primary"> FOR </span>THE<span class="text-primary"> WILD </span>
          </h1>
          <p class="lead mb-4 text-secondary">Highlights technical craftsmanship and dedication to outdoor performance. Short and bold, emphasizing flawless execution in any environment. Encourages pushing boundaries while trusting Arc’teryx’s weather-ready designs.</p>
          <div class="mb-4 d-flex flex-wrap">
            <a href="shop.php" class="btn btn-primary btn-lg me-3 px-4 rounded-pill shadow-sm">Order Now!</a>
            <a href="about.php" class="btn btn-outline-secondary btn-lg rounded-pill">Learn more <i class="bi bi-arrow-right ms-1"></i></a>
          </div>
        <?php endif; ?>
        
        <?php if (!empty($brands_data)): ?>
        <div class="brand-logos d-flex align-items-center flex-wrap mt-5 pt-2">
          <span class="text-uppercase text-muted small me-3 mb-3">Trusted by:</span>
          <?php foreach ($brands_data as $brand): ?>
            <div class="brand-logo-wrapper me-4 mb-3">
              <img src="<?php echo htmlspecialchars($brand['logo_url']); ?>" alt="<?php echo htmlspecialchars($brand['alt_text']); ?>" title="<?php echo htmlspecialchars($brand['alt_text']); ?>" class="img-fluid brand-logo">
            </div>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="brand-logos d-flex align-items-center flex-wrap mt-5 pt-2">
          <span class="text-uppercase text-muted small me-3 mb-3">Trusted by:</span>
          <div class="brand-logo-wrapper me-4 mb-3">
            <img src="data:image/png;base64,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" alt="The North Face" class="img-fluid brand-logo">
          </div>
          <div class="brand-logo-wrapper me-4 mb-3">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASIAAACuCAMAAAClZfCTAAABX1BMVEULCwtHFHMkP6L///8AAADYSh5FEHIfHx9dNYJNTU0hQaTx8fFIEXFEFnUGBgZEDHFZabMfO6G5ubluUI7R0dHcSxhAEXXj4+OysrJEKII+I4DdTBXLy8uqqqre3t5DQ0N9fX0APqiNjY2enp709PQ0O5oAJZo3DXd0JWM7NI+wP0gAKZvV1dXBwcERNJ8APquYmJhoaGgAH5gwMDB7SIGLSXbh4+92dnZaWlo8PDwWFhZPF24pKSltbW2aOFWGLFvgSgOEjsLU1+h4g726PznMSDG4vdqbosxFV6pndLYvAGV+LGBxKGe2S1SYSW3fcVW/SkZnRIqnSF80SqXAxN6pr9OPmMfFu9CLdqPLwtW2qsVoWZopIYonAHt0W5Hf2uWUNVehlLViIWurKjVZH2/YNgCjOEzJSTX43tnrsqh8O3avS1laRJGiRmGSR3DTSyjqcUtxRoUAAJTxw7nsoZCMjhOXAAAVAUlEQVR4nO2di1fbSJaHBVVAYzcmdkzsEBsbLEzAjxhIeAUI4RkSoAmQzEzP7kw224GdIWk2u/v/n61bJaluSSVLfhGY1u/MmRPrUbr11b23HirRBiF/+ttPkXz08FdCDPLnt6ODkXw0+vYhMf7yti9SE7391fjz6I824m5r9L3xMELUXIMRokBFiAIVIQpUhChQEaJARYgCFSEKVIQoUBGiQEWIAhUhClSEKFARokBFiAIVIQpUhChQEaJARYgCdb8Q/exSSxfb12uO62WVc48QMaPHZ2enp6dnx0GPmUaa1G9kfHY6BuqXN4z0/dzHb1Q1/hiKFZoVF8Pl46L4O47Iqi3X41lW3Vg/KOYIfrFqSU3384PWKaGYvAPdiuVzmJfRY0TBbtzc78dZu/Yjc/Vy1anL6j4iXMMR5NXjitjvPuEhqstLzU5DoPSgyq2qLURah3AaHnl9v+rtiqD6VlTorrkLcISMv46MiOqx//dzejiFwEDGm0XpjWXBPvAGnktjPXb725fxIBlz8lusf9ad7+0ECBWenoVQsPsJSzjV/cB69FAMkXrATvD9Tvehnr5DEXBL8iCK5FaEKFARokBFiAIVIQrUfUNUr9/6I+8XomTsYGehc0gxZUAjB3X68UzXEflOmrswtqw/IITEX5d1QzmP0AQYGWBPCR47Y+RxsaQC80YYJsuRoW1ulxA5BKZnx0e8gjncCF+VaXa7CpK3NDoYi3FCTEuHZXFK1GNW88ARaxmlT3dUv+SAD4zweTbMp7SI/JrasTymqdMszNX61FWOoMkvXvNgbQnTX75eZl84Mj772FkWYDP/f2OE4kNrWQZp+9+tUyMjTR7YiZBxMEdzaix8cNoj7p/2St+471Jfdyz6WTkI/y/Ojj4kxDQopUNp5kgvRzt9ZGgZfx23puqhF3VvwyyvLEKGwSgtE/L329tRbzwc/WG1bkWj71mUrQEhgDRPyN9ubUH5jq9d2xr9CRFijGq36Eb3A9HoTyYxhxxCBl0k5NYMvxeIRl+ahKxLQoxRlfzpttzoPiAaHWSEFjEhgxYJ8UH0yNJgG0+yPrFSD94DRKOjcUJWFUKsZ/NL2I+eXm6CPh31zczMWLhmZqx/89oP2hTRbYNw0chLIVYKu5zfMngfEA2+XSJkWCXEGGXIf4hKq63+6PPWmNCTJwNXu3Obr969uzy9urra3T2du3z1mVW+7+iV0NOXbMDN8T0a+fxpbo/d4uhmFzS3+Xlm5q4jGhx8+3dCVtyEDJolmf+cm9t8enR09JvjJI9mfrsZQBKoxqTgBwKBToyNDQy4b4XjA6ddQuT4rvBpW480Lh2uHKuAkZdvtwlZ9hCCZGR+GbPqO3Bzc7V7uflp83L3yUC3NcYQDcr6hRSK6z7x+7enwnc355hH717tXgk/vbRdesQmBnGhlDWIoI70feaXf9qc24XQuNp78uW/CJnyEjJogZAvmlbvOqGBAeP9zG9HT5lebV7Ozc1dXs5dfnoHv59+mpO6fHXELnq3KX6d7t2cMh8/mhFsLk/3FJ/ViDf13i4r+ujz56N3nz49dXT0bm/LcfwtVzEDX/5BSElDiDEi5JctHh4qFx4zzv1tSrnT+GXLG5eu355DVpDfXF6JSA/9YKcclA+ahcbYL4SktIQgX//6z5Pr3YGB09OxLbsSW2On12fX19fHx8esKXevbgaebCl64m+szFRbp6cDUOSYhagD3+yJX9tFA0oWZhk9IcjX+5VJS+fvvz/n+jrpFbxujiW5Yl9fnHJKY+CxorkGLCx7c2cnJ8dzJy+efz9nd02/f3HGwoORCoNIm/F7QcX2rq2tsd3rk5Nvp79ounuZr7craDlLMAhe/Js8Pznd2zs9ef71+Ql7BMNwdfzt5OT390Azxv7XbxeShAPn739niBSvd/wR7BX/vjk9vj77dra71SNIdiifnp2dfQNrn7+fButisYUlkvYhZNBVQtpbxY5NPns2aa0LsufAj8lma8bGf4+dMdcCP/3+/T3T16/n01AIV+x8+jz2TPjrs+njLRmg2qryfBseDW+LPei6dk+vn8fEY9AKd/21Z1St5mu+Ypqs1+s9fUVhHD6btJw00E0nY9PT3892b8bYOGSPyQpny/Fudo/PXnz9froVQEakfXbb8dcYb1BBxvu45DkheV9CBk2TD/X+evnNh4v9w3JP4Ai1vLwP/uRkyecn354L15sWmZGdf67G7RMRsF+sHvHJzTeWAK6vz37/OhnwpHqcxGnCH1GJLP1P/fUSX/Hf7yGjDt+AaGI41v/9ha3vX/shA9aT//jf/3vxz9/Pro9PIJSAZmDRlSX39N6FaJ6QbcBTzVcJOagEFtiufBFVKpXO3+mJsss7vKUPK/qA0qvMqj/fhJCRMHiptVVKaZ6QNz3LRz6IkvULM/6hKy2TrFwQYmbN1lp64UI7NVMjrZZfZnwMPo5c6lmo6RElkzzEtxc6f0CynxVVYzVJMz8K7ZdAqNicELwKoVaughHA61697dciSvbHmYUl1u4dPzZ5bkJlE0aCsowRCxkNC/shCCm0ssTsVTbSIUqyvoSNammq8whPxkx7tYdSM2w0lD8Q0miFEGuAbrSnXjpEFbHMl6Cs1+2waeqsqIL99qtASKj0BoSaDIj0btQgpEdupEG0sG01PLyKuQjV7sl6paLzNyhKTrLolDUgbq7yge/0vpkbmb1yIy8i1JfAe4bXIdomeb6/tH3ovbB+oHZLdIIsBfYAQKjWKqEW3Yg1aXicHkSVA7TMB+noQWBh1qaWD26HS75xrYdBx3Ogc0tkAxDKtU6IZ6OP4eoNk5ZtrR1auRHVD3EeSLB2J+cBsQGE4o2at/blJVJ1vdthY7yDBXd59djOub2tShDyn3Y0caOST+Z07f2rV8SkxTNnqZfL2vmwC1EyprYhTZjEbD6/BV/JsBFKlvmREkUQZkMuf6A5voNKKbDyEYZg4qCIsnYIsR6TkB2PpclK/8fXcikgWYl94JMWZsdHBWi9/HEpfvFGA9mFiDW8qVgIKTt+3sSBYT4ehyEuZX60rzDSLDsnwI8YJORJnBAcfFCuw3go1R4hjn/bVcN6+fCCe8ybMlQhWX7Df6bYpKWmpJBkeceaD3u7HRVR5YNnmQ/yB9nxBIe8JW77CiQu1AGyeYepqS1dTSuQyoxQla7k4OBH1gFm28hDVslsXovNTNbrB8w4YvIG2FmoLxzCtNcswaQlweYsDqP6AgeUmmKjW9OzsKIgSh5qBiR00eRNrIcE3boz8GEesmS3AsSfdoBMaSEnbIYrFz5AZDMt1ngr6l4IhWZkolkI85h9KDC3QmkxA9tI9wFDpihmdcwMhm+nLEgCxdoa5Zu7yEVSDRoVESETmrd64B5kWwsJ3E526zBIiNvT+23/lXkbEousC/CbBD+4mCYZv5XqcIiyTqQly9xjSH6d5wA6nOMNkF6h0tg1xugitnDOSaYWxXw4ARe+VoIGIwKPWNPYmKCFqoDkzkn1HdXtwNfNNzzsH/ivzIPNq05kOTMNZiPthJBBV1ik8epU3igeA2WvZzPZdaV8SgU3iL01eeEyBA1O2wgR5Ervy3PrxpWq1e5KtJ+73Q4mGXxCv7DUfHTDIInIwsHYZp6WhYpIq8MMhqSHKU6FEMwugxJ0I6OSFBfCntx9OVRwECUhK/hnAstXzYMkSvkwmXM9lw6xRnhdBvdqtmRo2JA6yT3eIlmksay8wyKIhWyIklmtplSSBg+aDI42C1Gych7Um7BkkeLd4rkNqaxzOwpdxf5hmK6JlbjRTUI80g4PlnjWD1mwx7XEwSKR0QaIktbwIahSrLiSKZ0QPEWzZGGFuK7D11wbriJhRXkHzyrSabmiixIVNR7AjAVKjodo0QTjC0ONj5V6ss4SkfZFYAJmlBn3uPpWxCYhxGSdU6dJDSoxzKONdePGg498WFlbCUmepXwGyfzw5kGceYpPdl9b7bZ/hBRdH9KGTjtFwdoNzJb4a4R4oxWXp+AlXAW/m34QoC4/WfRt2wxRdrhF8CzcSswLJzoa590HsU6XjXWMqXYck1LNMONfUZRumIZvsETiYo7wLx8tnStCFKgIUaAiRIGKEAUqQhSoCFGgIkSBihAF6g+CyL202Ir+CIjg7x8stj+n7Cmizpe2uiFq5GEdMNPuOnkvEdGO/LtrVmxYy1sBK8++axc9REQbJJ4bapdRokt0Yc3fVrMi6UYqpV+b7h0i2KpBSKKtiiZYi64lumIavJi21eS9FU0VKS1qd8f1EBF/E9JW8Qm+JNr6dj6tGQR5kf9VxeVSrVZc1uWrzhA1c9wSXxbHxYd2KCre1HblLRtC5NRfs2GlRvMrizmqa5XONhr4priE9Q4Av8+m+hd7mmKHglNHeBuzGkIeQxibfK063x6ihPUNgWa9mhZIrrhIpeQZyw8YokTCSkcJSiYaBXS1CwA648WrnNaRs5+usYUzmmjIY8yQkssQWlrNrhi5Vd1m5qaIAA/dyMKmpWIuHo9P5JVX5fyV5XChUcuwc/F0fsXeukM3TEJkNdd4nfjmnTxLiVW4egLSYwI/aT4vTtRK87AVKlvLYuR0vpQTj8kuu30ArFzJZ/k2mUVeSjW/KgundJ0XkLU2zfFRQI4Ws8iQBK0yaMNVHX5fRBzPfH6CjyemnHhGW4ASPMxRhyHe6NK1KXzMcQf4woFk8PG8bFeRuZAwB0pXU8rJ9Dy6k9JCA3a+pam1BU6oJvfDwBXwcCuK4HMU1ZAsXJNNpfRvun0/z6UrpaptkVKes4ERgcMPG/Yc5N4LuybdiluvtWFfkksTiFCi5j1dsBx2qFizPDbNP7rCJYitXetT9u0CkZ3psMx1mvALYT9EMsl5Zac0GtecLGkQ8T1Eqv2WxGeLDutqSjZG3B7E4LEfEiRfiv01RzPqFdCWtIGusBCVfA3Ryw/RhNYuIbEfxMf0IS8i3uLU1FzMHYwnKVDR2m1oSTCSHlbaKGJ3YrmH4vhzASJ8GETT6LeFSNeyzT46aQeRMN7ZB5fJ4Npn6ca8dJjMyvw8/zjRmSllMoqJVDo+H0PxrT1CfP+NdMphnlTQrSVK1RTl1grVIHKQuw3xdSM/RKWihJRjeaGIMcCmGatmsIeZ4lwSV1xhwu5/ha0sn8PUAvFfkfVMy6wulKX88xch8V0I3+Ms752aV5syo7gSi0VampLlpWTLxpd56pHnmnxl6p+uJf8sH/RhY1aplUCsrgVnbpb4pCfYY5vEmqimlWRxNZwfYnMkzmU0IXOi/ekOehK0BmaSBzORY/Fk5Di7QCS6YY0h/h/A+Xb6CJGgj5MJf/h6ybSnCLhe61SDCDbH5ZyPO1DF8nKtwroWnSxSw/m3bShOJUWMyCxQaiC3s/peFyLYyYAMke3uv1ISGhHOEqI2aHyKe/SCFpEYZ9mSluVlB2PN55ztS3BS+ozTwcnTEMYSUdZDWItINaTqvr0jRAllzgyZlBam8tlULZeeiKOm9UHEBkylXC5dnYAxsrw6jyJDtC1KyTVUBQeRdCz4tKJ1RGBIzWtINxDZ82+udZaMNrzdrD8isXfQqzwq1cqYsilqqFWcvx6Ck+Jy64j8DOkOIpQpC5R6h7zOKS8i3UicK48GqdbYRLpOdk1e6GxfxkO/RsuIfA3pDiLUtQ9jQmY6h4YfOkQ4j5GJXE6mVJxu7GTkhF4RdfHONn9sRrZVRP6GdAcR6rYWN+S/YS8gqosGEV2Xp3NrrnSNMr31uboz8sQjdTk1RHOsVIuI8L3ckO6ma6WiqOtdZlkWj3p1iKTL5finPRgRelBVRZTG5OUnJShB5VtFJPuGtMuQbiMyZfPyajVHhPtCPrdXESHyy0qlVnGjmxKRhDDVKiJZ3rrLkG4jSpeQlYGIUPYQ36gpiJT58AoaY7Hsg4erui5tvkVE8klxtyHdzkVT8rnFEIhKzu+qBpHCKJe3YwEKRvVDyUje3erQUXYNE71BJFP0kCw6jBfJfl3nRYa1T15RRqygoA7IeZkiIaRbRSQf0yMvcob+E8gOPgNH9JojEiNoijt9KDpB1xpo1k0yy9Q7oncmhM6R+fYReQzpDFHOPaSbR50lfCuawKMkBRE0lrJg2oD+DwWWvZTF+mPb/ni+IJem0YzMWhmU3Rzj3yKikssQNKjoDJFF3DGtqgRGfIXiigAitHTIJuPr+DeMouZREua5CN6ZCOjxWnFdecGBVzvEJ/wS+GrLiFyGrCBDOkSU4gthzlBoiGrW4x2tUmXJ1swwY/yvZp0+HdrI2ramU6XiMH4NhocEwg6ncOjxFEQirckjDf5Fsk+n75b/d36hEJFMvqTONt1L6fhZJbclmSYLqOlSYd1zsNqQH0Mra7FmStoBa4rLJTmEnSgBs1JDeka6NEwbpQy6Ytj/rcVEyefb6ZCIsDbcXRivFF63pe57h91r+6gvZ1WtEq/SjmF0XdscvKHUqTS8SVMvWnY9uOFe288pJ7uDKD7sndNCuOBnUdc7M+ZWQ9jUiXWcE4pKhpBykoOa6oRSfGeNyzt1iFQkDTqED2QUQzpBJEs1GzIAFp0LctCJmXFHzNJhiYSPcFCCh5X1RXm1yX7mUtlUrZZ2tbD8Q0+UTmFPiuetOKRZ9NS4WYPheBwf2aAZ5TfMuJ1sH4euxMQn20eUpcV8LZersWhFr1LgPWcql0tNDVGrV0I7DlgXlc8x1ewX/fDlcRbKGHZfbf+c8sSbfCnB7jaWSzVeYBHt7KSUeh6sHvFc0dSQthGlfAppWrTnnkTTq1eF22UWkbsofy8iuCph1dQQjVoYXfdQzpS+gTtpv7/Lcsu6I4jsvDtPE3I8ofkzOD9C4V41du7dzeVggQFzQz63pw8NK78X1u7c2dtd/s6MG17DOx1xwB9muS2F3fbQY0QlJ0PL4UFX/ypNBwqLyG903h0lnCFeulG7Y4R8EW1MqWp7F344UWV4Du50R6LMaJauVfX6Ww5KC3k7Z5vpqbUe9w+t6O58bAUNsQbqxvCwm7o7iED+ezJ/oO4WojupCFGgIkSBihAFKkIUqAhRoCJEgYoQBSpCFKgIUaAiRIGKEAUqQhSoCFGgIkSBihAFKkIUqAhRoCJEgYoQBSpCFKgIUYCo0fQ/ghzJoKtGG//lyD+UaN6A7yju2ru9uyP4Cxz8P3IxFMlHhTwh/w9b1lotojJ42AAAAABJRU5ErkJggg==" alt="Patagonia" class="img-fluid brand-logo">
          </div>
          <div class="brand-logo-wrapper me-4 mb-3">
            <img src="data:image/png;base64,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" alt="Columbia" class="img-fluid brand-logo">
          </div>
          <div class="brand-logo-wrapper me-4 mb-3">
            <img src="data:image/png;base64,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" alt="Oakley" class="img-fluid brand-logo">
          </div>
        </div>
        <?php endif; ?>
      </div>
      <div class="col-lg-6">
        <div class="hero-img-container position-relative">
          <div class="hero-img-bg"></div>
          <?php if ($hero_data && !empty($hero_data['image_url'])): ?>
            <img src="<?php echo htmlspecialchars($hero_data['image_url']); ?>" alt="Featured Product" class="img-fluid hero-img" style="max-width:400px;">
          <?php else: ?>
            <img src="https://www.bluemountain.ca/-/media/blue-mountain/2400x1350/retail/brands/arcteryx.jpg?h=100%25&w=100%25&rev=d7dfbad1f9024ddd9f2bce3312003499&hash=E99DD281BED6259F427DDAB150A65E79" alt="Arcteryx Logo" class="img-fluid hero-img" style="max-width:400px;">
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="hero-shape-1"></div>
  <div class="hero-shape-2"></div>
</section>

<!-- Featured Products Section -->
<section class="featured-products py-5 bg-light">
  <div class="container">
    <div class="section-header text-center mb-5" style="background-image: url('asset/images/upload/arcees.jpeg'); background-size: cover; padding: 320px; border-radius: 30px;">
  <div style="background-color: rgba(255, 255, 255, 0.3); padding:5px; border-radius: 20px;">
    <h6 class="text-dark text-uppercase fw-bold mb-">Discover Our Collection</h6>
    <h2 class="display-6 fw-bold">Featured Products</h2>
    <div class="section-divider mx-auto my-3"></div>
  </div>
</div>

    
    <div class="row g-4">
      <?php
        $featured_sql = "SELECT id, name, price, main_image_url, slug FROM products WHERE is_featured = TRUE AND is_active = TRUE LIMIT 6";
        $featured_result = $conn->query($featured_sql);
        if ($featured_result && $featured_result->num_rows > 0) {
          while($product = $featured_result->fetch_assoc()) {
            echo '<div class="col-md-6 col-lg-4 col-xl-2">';
            echo '  <div class="card product-card h-100 border-0 shadow-sm rounded-3 overflow-hidden">';
            echo '    <div class="product-image-wrapper p-3 bg-white text-center">';
            echo '      <a href="product_detail.php?slug='.htmlspecialchars($product['slug']).'">';
            echo '        <img src="'.htmlspecialchars($product['main_image_url'] ? $product['main_image_url'] : 'https://via.placeholder.com/150?text=No+Image').'" class="card-img-top mx-auto product-img" alt="'.htmlspecialchars($product['name']).'">';
            echo '      </a>';
            echo '    </div>';
            echo '    <div class="card-body d-flex flex-column p-4">';
            echo '      <h5 class="card-title mb-2"><a href="product_detail.php?slug='.htmlspecialchars($product['slug']).'" class="text-decoration-none text-dark product-title">'.htmlspecialchars($product['name']).'</a></h5>';
            echo '      <div class="d-flex justify-content-between align-items-center mt-auto">';
            echo '        <span class="fw-bold text-primary product-price">$'.number_format($product['price'], 2).'</span>';
            echo '        <a href="product_detail.php?slug='.htmlspecialchars($product['slug']).'" class="btn btn-sm btn-outline-primary rounded-pill">View Details</a>';
            echo '      </div>';
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
          }
        } else {
          echo '<div class="col-12"><div class="alert alert-info text-center">Windbreakers are currently out of stock.</div></div>';
          
        }
      ?>
    </div>
    
    <div class="text-center mt-5">
      <a href="shop.php" class="btn btn-outline-primary btn-lg rounded-pill px-4">View All Products</a>
    </div>
  </div>
</section>


<!-- Testimonials Section -->
<section class="testimonials-section py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <div class="testimonial-image-container position-relative">
          <div class="testimonial-bg-shape"></div>
          <img src="assets/images/testimonial-image.jpg" alt="Happy Customers" class="img-fluid rounded-3 shadow-lg" onerror="this.src='https://www.reading-b.com/wp-content/uploads/2022/02/downloadable_arcteryx_06.jpeg';">
        </div>
      </div>
      <div class="col-lg-6">
        <div class="testimonial-content ps-lg-4">
          <h6 class="text-primary text-uppercase fw-bold mb-2">Customer Feedback</h6>
          <h2 class="display-6 fw-bold mb-4">What Our Customers Say</h2>
          <div class="mb-3"><span class="text-primary fw-bold">240k+</span> <span class="text-secondary">satisfied users</span></div>
          <p class="text-muted mb-4">98% of users recommend shopping here because the items sold are original and reliable. Here's what our loyal customers have to say:</p>
          
          <div class="testimonials-wrapper">
            <?php if (!empty($reviews_data)): ?>
              <?php foreach ($reviews_data as $review): ?>
                <div class="testimonial-card mb-3 p-4 bg-white rounded-3 shadow-sm">
                  <div class="d-flex">
                    <?php if (!empty($review['avatar_url'])): ?>
                      <img src="<?php echo htmlspecialchars($review['avatar_url']); ?>" class="testimonial-avatar rounded-circle me-3" alt="<?php echo htmlspecialchars($review['reviewer_name']); ?>">
                    <?php else: ?>
                      <div class="testimonial-avatar rounded-circle me-3 bg-primary text-white d-flex align-items-center justify-content-center">
                        <?php echo strtoupper(substr($review['reviewer_name'], 0, 1)); ?>
                      </div>
                    <?php endif; ?>
                    <div>
                      <div class="fw-bold mb-1"><?php echo htmlspecialchars($review['reviewer_name']); ?></div>
                      <div class="text-warning mb-2">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                          <?php echo ($i < $review['rating']) ? '★' : '☆'; ?>
                        <?php endfor; ?>
                      </div>
                      <div class="testimonial-text"><?php echo htmlspecialchars($review['review_text']); ?></div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="testimonial-card mb-3 p-4 bg-white rounded-3 shadow-sm">
                <div class="d-flex">
                  <img src="https://randomuser.me/api/portraits/men/45.jpg" class="testimonial-avatar rounded-circle me-3" alt="Raffialdo Bayu">
                  <div>
                    <div class="fw-bold mb-1">Raffialdo Bayu</div>
                    <div class="text-warning mb-2">★★★★★</div>
                    <div class="testimonial-text">Trusted marketplace buy branded watches of the highest quality.</div>
                  </div>
                </div>
              </div>
              <div class="testimonial-card mb-3 p-4 bg-white rounded-3 shadow-sm">
                <div class="d-flex">
                  <img src="https://randomuser.me/api/portraits/women/65.jpg" class="testimonial-avatar rounded-circle me-3" alt="Dinda Anggita">
                  <div>
                    <div class="fw-bold mb-1">Dinda Anggita</div>
                    <div class="text-warning mb-2">★★★★★</div>
                    <div class="testimonial-text">Product I bought here is original, has a certificate of authenticity.</div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Add this CSS to your header or in a style tag -->
<style>
  /* Hero Section Styles */
  .hero-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 600px;
    position: relative;
  }
  
  .hero-title {
    background: linear-gradient(90deg,rgb(136, 88, 139),rgb(32, 42, 240));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-fill-color: transparent;
  }
  
  .hero-img-container {
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1;
  }
  
  .hero-img-bg {
    position: absolute;
    width: 400px;
    height: 400px;
    background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(13, 110, 253, 0.05) 100%);
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: -1;
  }
</style>

<?php /* The closing body and html tags, and scripts are in footer.php */ ?>
<?php include_once __DIR__ . '/includes/footer.php'; ?> 
