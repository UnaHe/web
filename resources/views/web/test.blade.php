<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Test</title>
    <style type="text/css">
        * {
            margin: 0 auto;
            padding: 0;
        }

        .btn {
            width: 100px;
            height: 30px;
            line-height: 30px;
            background: green;
            color: #fff;
            border-radius: 10px;
            -webkit-border-radius: 10px;
            text-align: center;
            display: block;
            text-decoration: none;
        }

        .container {
            background: #e5e5e5;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.bootcss.com/html2canvas/0.4.1/html2canvas.js"></script>
    <script>

        $(function () {
            $("#btn").click(function () {
                html2canvas($("#container"), {
                    onrendered: function (canvas) {
                        //把截取到的图片替换到a标签的路径下载
                        $("#download").attr('href', canvas.toDataURL());
                        //下载下来的图片名字
                        $("#download").attr('download', 'share.png');
                        document.body.appendChild(canvas);
                    }
//可以带上宽高截取你所需要的部分内容
//     ,
//     width: 300,
//     height: 300
                });
            });
        });
    </script>
</head>

<body>
<div style="padding:10px 0">
    <div class="btn" id="btn">截取屏幕</div>
    <p style="color:red; text-align:center;">先点击截取屏幕后再点击截图下载</p>

    <div style="margin-top:10px">
        <a href="javascript:;" rel="external nofollow" class="btn" id="download">截图下载</a>
    </div>
</div>
<div class="container" id="container">
    <p style="text-align:center">以下是测试内容</p>
    <img src="/web/images/1.jpg">

    {{--<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAEACAYAAABccqhmAAAZ2ElEQVR4Xu2d4Xoquw5DT9//oXs/6N20wCTjJTTO0Or8PU5sy7LiBMr++O+//z7/e5P/Pj95qB8fH5vZjfai9gp0Ix/KXs41FF8lD5cPuo+C0yw/yh/Ff8eaS3fwruqIbMOHUnTa0NRegUJpHMUPXUPxVfJw+aD7UCwu9hEABbUD1yhFpw1N7ZV0lcZR/NA1FF8lD5cPug/FIgKgIHbwGqXotKGpvZKy0jiKH7qG4qvk4fJB96FYRAAUxA5eoxSdNjS1V1JWGkfxQ9dQfJU8XD7oPhSLCICC2MFrlKLThqb2SspK4yh+6BqKr5KHywfdh2Lx5wWgA+BRUWgTKkQc+VbypvG6ybi1n/JKTXPvyFvBivJK8UHxpdgqMSl5Dz8FOGPAFHQFRCXvjkagIqdgRXPvyFupodII1A/Fl2JL45nZz7gTAXhATilURyNEAF5vCYrhzGME4PV6DHegDdVRWEVhFTFxnV6UoBe/NF5apwMpU9q6gydnxCQTQIkeX0a0CWaPRcpeEQBQLGgaAXgGLFeAXAFuCFDBOuNpp0xqUEemB8UZMbFOAO+mojReZXQeEahjLzox0CafTTg0b2VaovVzNrOyFxUAZ34K3/AEsDLgleRV8lYKojTV1hpKROfJOasTjUvBnTauwiuX8DrzU/gWASheAZRCKQWJANwjoOAeAahjGAGIAOz2C23CTADPkDoPA3pI5A1gl+LfBs5CdezlGkVzBQAkmZiuvOIofMsEkAlgl/mZAHYhuhlEAOpYDT9zpyACl7umlOyzDTsel3YTAgbOeIHbq6kTdzoi0ynqYk9PW2pP8VNiuuI++kWgMwbcQVAnEZ3xOuNyNYhCUqXZXH5oPWaY0/6g9krOio8IwAPSzkajhHPew50EUvaia5y4uwQuArCBpLNQVLGcDdVxEjnjdeLuahDa5O8mcBGACMBLHI8A1OE7o8BFACIAdQZvWEYA6vBFAOpY0QnuT38P4HVYv3ZwngaumJSXX0WUOj6VcQqAkuNWTZw1p9ddhSOKjzwCFpF2kqHosmRGi640RwTguRQu3DuELxNAqZXmRhGAehMocHc0Ao3LWXMqGDRWZRq8Trb5HkANaicZah5rVpRYmQBquLqvfbRO9Si/LRUfEYAi0hGATAA/EaDNRu2LtLwzU3xEAIpIRwAiABEA83e2qWIp42uxv3fNIgARgAjAbpt4DOirs/KAtFJ8nPGOED+rD8oQWqfZYxjFSjlwKHcpHoq99VMAJQC6hoLoJDv1TXPbe1wa7UfJ6MSENo6CCc1bmchoHhTzWW2VvVw4RgA2kKQni7OAZ21OmqOSByU1rVMmgGeEIwARgFLfRQDuYaJ4ZAIo0WzfiI7hyklETxaFDHTknCFD/TsxceaxX/1aE+YKUEcyE0AmgBJbOkSmFMgPIyrUuQKYrgC0UB32TjI4pwwaF7WfkTp5PDOP4kvtlXp09IfiY/hFIGWzo9d0FCo+6idIsKpjdXRvqPtHAB6QC6nrpA5WdazUBj16XQQgAnBDgDY0tVdG59/i4+hGVvePAEQAIgCfn5v9o3zSoHz6ojavY10EIAIQAfjLAvBJP/txyI55j7OqLh1fZ6Wgr/0jiJVTjZZL8UFrqGBF85jZ/4K2uab3EQFw0uJ+rwjAM7YUk1F1IgAe3kYAPDhu7kLJrpCankTK6UwhUnxkAqAoe+wjAB4cIwA/EIgAHEgq89YRADOgP7fLBJArwIH0smwdAbDAuL1JBCACcCC9LFsfLgD0bqdk5bw7K6/typqtPBWsqMgo+NI1Sj2Ux77Rmo56uHCnbzizWih5RwAeEJVA/Lh8naJ+2lHizoruIiJtciWmyxoqckqDKDWkguzCXcmP8mcqyEd/DEgLrhBROXFoAZ0+aAGVZuvAXTm1aVxKg0QA7isTAQCns0IeZQ09cWiz0UZThJfGlAng9SkxVwDQzDPCZQJwtjw4cQbXJUVM6CRFp4nVH2fSCikHUd4A8gZAebZrr1yXIgC7sO4aRAA2IKKgUHtlyqAnV94Adrl/Z6DUkF7J6ATpFDjKn6kgj/5xUAa519o5qrmAV+7ULpJccqB7UXtvBce7uWpL93EKtYKVwh8Xd6fvBhGAWjmVAjqbkO5F7WsovG5FG9d1mkcAtmt3yt8DcJFEGZ3peKX46BCTCMBzZZxiQqVQqXkmgCLKCrgrRcYZLyW14rtYhpKZC3e6TyaATAB3CFACKY3jPIXpXtS+1L0GIxfudJ8IQAQgAiB8FdfQ84fgHgHwVGb4PQDlxPOExHdxkoF7H7/Q072UL568mw96r3XykPKkw7ez5kq8EQDaQRv2lFjKQ+Nv8REBuEcgArCoARW1pOSlqTnJcFaRoRiurFOHb2fNlXgzAdAuzQSwi5hCxI5HSzpFKXk4Ba4j3gjALp33DWihzno6d+ThbJD9ytxb0PwiABThRfa0sJcwO4pL4XCOg2cVmQjAL30DcDahshdtNqVBVpKX5qeM1BR3+iUkmoNqT+NSDgMF3618Zpi78pj6GP0iEAWFkmd2Cit7qWR5XEfzvqx3kcGVgxoTxZ0S1JnfbC8a18qaRwAOfFRTCLeSDEq8zqkkAlCvgEv0IwARgDrrgKVC0AhAHWAF31wBHhCgo1q9PLplJoA6dmesn3K1XFnzTACZAOodByyVEyoTQB1gBd9TTgCjHwRZmWC9DF+Wioo6fdC9lJOTrnm3U41iuNqeimVHvJQj12kpAlArjbPgUqHgPz4SAajVVbVy8kGN4XGdxKsIQA1+Z8GlQkUAaoVqsnLywRWyxKsIQA1+Z8GlQkUAaoVqsnLywRWyxKsIQA1+Z8GlQkUAaoVqsnLywRWyxKsIQA1+Z8GlQkUAaoVqsnLywRWyxKsIQA1+Z8GlQkUAaoVqsnLywRWyxCvXvw4sOYekHgE1e/GmhVLyoAVc6WMWK/3ol9pffNN6UGwVe6UedI3yqQzNRamH7d8GpIBcklPWbIESAXhGRSEcJRC1jwDQlmb2Sj0iAA8Yu0RpVrqVPjIB1MVS+YKZ0oSszcfWiu8IQATghgAlELXPBOBq9e19lHpEACIAEQDhLYpOccqVjMpFBGADMfroRAtLi+R8+1CuGbkC5ArwEwE8AVAlow2oNIjyCEjzUBpdyX3kh8arnAbKmq14O/LuuJ87fbjqqlyjZtyJACidXVzT0QijUJRmVtZEAO4RoDWnwh4B2GBcJoBnUJRmVtZEACIA0/OQKmKuANtw0pNCaWZlTQQgAhABGCCgiJ/rrqg0s7ImAhABiABEAO4Q6BA+5wOd8smPsmaLJnSy+xNvAPQUVMhQfMe7mTlJTfObFZ0SyJmHqwlmtaD5zfZyTTiKD2fNKXff7lMAClYEoE6JCMAzVh0iQzmtnPSKj1N+DEgTiQBEACoIZALYED/658BULVefODTeEZGceVCByxWg0t77NhGACMA+Sxoe9CIA9TK4BNwponkDqNfP+gMQyqOTi0CZAOp3ZydWrvpFALabdvjvAtBRuKM5ncSip/BK30Bvd02V95KO0dnFt10ANgxW1rajHlMfo98EdBVESZD6VooeAXj9RHeezrTmTt8RANBB9DSIANTBdZKaNtTFnk5xK+N1+o4A1Dk6vNNT8swIp5AXpDA1VfI42rdr/9k9OALgRPn16cpZj1wBQG0jAM9g0akPwL1r2uE7E8BuGb4NaEFyBaiD6xxrlSmKit/KeJ2+IwB1juYKALCipk5SRwDq6P9pARh9E3DlaeAsiCsPZZKh09KMsnQval9vl33LDqycPkYZzQSZ4kvtZ+81zoNi+LcArsbZp0v9zqns5crDSTilgJRA1F7BduWU4axHBGADAVfjKMTKBFAXxZV1igC8/trvnDKUXssE8IAabSjnxzW5ArzeUEo9MgFkArghEAFQzpH7Nc7xvKMeEYAIQATg9b6/7RABeP0K1/YIOPpbAHoPdyq1crc08ndzK+XhbmUeSry05srJ6aqTEivlqHI/p5g4xZL6vl6XIgA1SioNFQGoYatYRQDqqM24GwEo4hgBKAI1+aOi+g77lhGAfYz+WUQA6lgNLSMAdRCdWDmnqFwBntHMBFDktZPUyulVDHP3MXO2jysuJ1YRgPqDYt4AaJcAeyepXY02C1+J1xWX4huU4mqqxJoJYGMCcP0tAC3g9QXy4zKAHKtwClG2YlJI7fLtxFaZAFx1ctZcwaRjDeVJB0embwARgBotaGHVU6oWzb6VM94IwD7e/ywo7hGATAB1dgFLSsSZYEUA6sBT3CMAEYA6u4AlJWIEAIA7MaW4RwAiAB7mPexCiRgB8JSB4h4BiAB4mBcBOARHuumvEYBR4s77oMsHBV15oJv5oCquYEjXKJiM6kHzmzUNzYNyxF3bozFx8oqK1cXe9q8DrySJQnYar7NQShPQNQomR5P9SrgTfvSrYEX50yFkEQCAAC1gBACAKzySnbEes4xpvBEAwB96SnQoeAQAFDACUAbLyauy0x+GuQIUUXMWigqcMjoropgrQJEM4leRt3Z38qoe/bdlBKCImrNQEYBn0OlI3VGPXAE2EFDIW+yxmxn1oZx2ZySc89dhFEwyAdSZSvlz2jcA+otA79acHaSu00a3pLjrnp5XUjFRhMwZL91rFK8yZTixonkoIoN/D4ASkQJySYKqa4cPVzHUfSjuqh96T92yjwDU0adcr+/8454/+Oj1YhEBUBBdsCYCcBzomQA2sKWgUHvnA0smgOOa43pKTE6QTAD3CDixclV1FlMmABfKB++TCeA4gJXDS1lDxdKVcQQATDgu0N37RADciH7vpzSzsuaUAjD6RSD6ougCRLka0LHr4sP5+KL4d9GZ5qG8bLtinV0nKH+Uh0YnViNMaB5Oviu+D/8ikLM5lARpoRSyO3Ok/p2kpnvRWCMADDHKd2p/rUcmAFaULesIQB1DepWh9orI0GnXeWo794oA1HmYK8CidxHa0NQ+AvBc2OkjYCYAoBoD00wAdQxpQ1P7CEAEoMRG5303AlCC/GpEG5raKz7+9BVg9LcA9ZL6LeldRmlm2rSrfXTESxtBwYT6GNkrnwIoe1F2U8GidXW+GVzFMgJQK7FCdlrc30LqGqL3Vn8VK5p3BMD0eEWBjwA8A69gkgngNeGLAEQASgdsR3N2+FDG9g5xp0JGr7WlIj8YKT5yBSgirZDdSUTnXsWUb2b0Xkv3nz3cRQDqaEYA6lhZ/8KNnga/ndSgDLsi89uxosLedgVQTryt4JTvntMTZzWIVHmp/QVXZc1WPVx1VZp8tobW3LmX07cTFyevh4cU/UkwmmAE4BkxpZmVNRGAewQohqvFMgJgeOSggkVJopzOHT6U0Zli5bR3nsJ0L2rvzFuZZJz+8Q+CUOeZADIBVDjjbEK6F7Wv5OOwyQSQCeCGgDI15AqQK8CeEGUCMIgMbU5qr1wzcgV4ffLKG8CefBT+f64ArxMxAlAg2g8TOtJTexaNbr30CqCH/fpKp/JSEJ2n8wgJGtMM0XfDik4mClZOTDpqeDQm078xeac/BlKkhRIoAlBHWcHqaLLPpqV6ZvuWlFf7O3omRfru81ZfBVZApIVSSE1PHBpTJgBWeVoPtvuXtbOGR4tiJgBQ4QhAHSwFq6PJngmgPklchSxXgHvAFFLTE8d5elDfs/amcSlYRQD6BTYTQB1z6Tv3tAlpo+UKAApo/jcf/uwjICU1K5H3HqXESj/6UT7OdJJHyVGpCVnjFDLi9wxjPq0H5RvFQ53sDv8ikBoYAYAWY/aIo4y11L/SONQHwU+1VfJQfT2u68CjQ/RX5xEBeGBWBKDeohGA17GKANQxHFoqINKRrOM06LrrGyC/bhEBqCNJ+Vbfed9yVqdMAJkA9hk0sIgA1KGLAGxg5SJQJoA6EZ2WrvopMSk1p346pr7VedgmACcZKChKoagiKz5GhKO+lYdU5S2DNgit01mvDR3c7fBB63eth+snwVYmqDQnbULFRwTgGQEnTyjhV4qiM29FeIdcjADcQ6OQhBaEik8mANrq2/ZKbannlT5orJkANhBTChgBqFPPeRLWvX5ZKrV9Jx801ghABEDhzG0NFb68AbwE90u45wrwgAAdw/MG8EyhCEAdE+fko+COBWC0gI5Rs2ApKM7E6QPdTLtpXDRvZXyldVLyoyKqnH8dPpxx0b5RfFPuTnuQ/jkwJVYE4LlcEYA67SMAx2KFfw8gAlAf+6hSd5zCK8WnTuVvywhAHTUFqwhA8W1Aac4IQJ28FCt67Xo9kvsdqJB2xBsBMFSZFnZ2P6ekVkSGFt2ZH/WtlKfDhzOuvAE8IJA3gLwBKA32b00EoI6eglWuALkC7DLM+e6z66xYj46RehYrnaQ64rUKAC06LWzHuOssoDNeJ1YrR07nFYfmoXwvgzatUnMnJlQ0IgCgszrI4PQBUruaUvLQ/c8srh2HF8VX4YLLh/Q9gA4QXapPgbr4VQriitfZbDSmDt+rse3gLuWcgonLRwRgg/VKQWizOX3QxqXkoftnAvhEkClcoDXMFQCURClIBKAG8GpsMwHc1ykTQCaAWuearCIAz0AqmLRMAJ/Uy4AkyvjhfDGl3KWnhPJ9BuqD5uB8pZ69i1CKOF/onRh25EFruBqrjwjAfckUIaNrlNOAEouSPQLATm0F360aRgAOHs9d9/ZMAHUJWk1qWnNlEo0APKBGT8GuV2RKBiUPuiYTQP20zRXgWKxyBTAIWQSgdo26WNGGpvbOdxFlkqnPSV+Wig8n3yIAEYAbApRYztGZ+lamKDq2K80ZAXhAwHl3puDuKSzZj5KH7P3PdjXh6HVJybFjDRWTs8ZE81BEcekEQBNUCqWAsuUnAqCgv2ZNB69oZkpMdI3C9QhAsZIRgCJQJzCjjdMRshITXRMB2KikAkomgHsEOsTP2YS0cZy+6buI84qscD0TQLH6HU2QN4BiMXbMIgB1HCMARawiAEWgTmAWAagXAf8kWH3rL0ulcd6pgDM86GfYHeOgUg/nWEv5o3BBGYVpXCvtrbyi/zAITVwhnFJ0Ghe1V0hlLdTHRauf/3P6cGGi1NwpMkqtaO4r7Z01zwRQrKRCKmuhIgB3lVKmpWKpT29m5VUmgFq9IwDPOHVMaooPpVY1FpzDKgKwoA4KqayFygSQCeD/CFh5lQmgpiYRgEwANaYcbxUBOB7jJw8RgAjAAtod/vBr+x7ASnCczenMQ7m/uvwrmLh8z/ahp5cSk+tTiLN+MUvBZPgpi+snwZxB0b0UsrtIMos1AvCMTgTgHhOFu7Q/phyNADjhrBV3pfgcl21t5whAjSM1NF+3yhXgdQyHO2QCyASwR69MAHsIFf6/AuLKU3il7wKch5pkAsgEYCdYBOAZUgUTe2E2NowAnEwAjv4egJNUCnlcp+1ZG6oDX6ePlTgq/BnlTvei9grmio/D/xZAScQF+mWfCEC9Ai6spq/Og2801qPULZUGcXHR6dsV02WfCECRTytPrmKIL5tFAOoQ0oam9vVIvi0VHxGAItIRgCJQO2YrcVQaxHXaOn27YsoEADi9krggzJdMMwHU4aMNTe3rkWQCkP51FQpwBIAitm2/EkdnE9K9qL2CtuJjeAXoOA1GSdIv0CikomDN8OiIl459CoFoPTpiUmpLc6dcuOzv6g8lPxrvlLujjwFdCdJiXO8lpr99n/m2gtgQb0ezRQDuETjrHwNZuRsBqBU9E0Bdyp2Hh3JC1iP9sqQNlQmAIgztMwHUAXM2WyaA2mEQAajzU7KMANRhiwDUsaLXqFwBXsdW2iECUIctAlDHKgLwjAD+FMB5J6N3L2qvPAK+TqfvHZxCRhud+u56fKVN2FEPpw/nXk6+D6939BEwAlAvMW1C58hJfUcA6nXtsowAPCDtBISeqErRaRNGABSU62uch1fdq27p5HsmgKKY6OXauF8Zvx9ABYuKTyYAZ+U9e0UAik2rKDttKKWktAkzASgo19coPKnv7reMAEQAbghQwaLikwnA38Cv7hgBiABEAF7toh/rMwFsXFN/w6cAM46sLDo9tZU8nKeEK17nVWb4eCX8stBKrJwT2QgTJb9f8T0ApXGMB8twK1dDdY3nrngjAK8/CM9qHgEA3ZsJoA5WBOA4rDIBbGBLRxaFoBGA40itjOdKDbf8KHWlfJshR/OIAEQA6p24YUkJ5GwQGniuALkClDhDFZmqrnKPKgVeNFLipacqxdB5qtFYL/YuTJwC59yLYjLDg8alcOHXPwK6CtJxqhV15a3NOiYZ1yOZ0pwuget6+I0APLBFUVFn0d+6uwvBRwAKIP3fpAOrCEAEoM5Ig2UHqTMB1AsVAYgA1NlisIwA1EHswCoCEAGoM9Jg2UHqTAD1QkUAIgB1thgsIwB1EDuwwgJQD1+3pIkrnpw+6F7UfvYiTHNXXrZX+lAeWCm+9OO2Cx40LhoTxVzlSASgOAHMCkKLS+3V4m7FHAF4RiUCsMEUqnCKYo3WKA1C/Tt90L2ofQSAVZfiGwGIANwQUITPRbh3O53pY5siZCvrMZMdGhflCJO8L2tFyHIFyBXghoBCoKOvGbTRZo2gfMlLEbmtNREAIGkrwVpJuEwAzyRZWY8/PQGAfm0zVcjgCq7jbwFcJ7BKXJd/pU7UtyKWNC4ak4tr//ZxTSxTrEY/CeZOxrEfLaDD5789IgB1NJU60WaLAHjqMXwDqG/fZ6kQyxVdBKCOpFKnCED9+mPFKhNAjdgRgBpOF6sIQB0r5boWAfDgi3aJANThigDUsYoAAKwUYoHtp6YRgDqSSp2spxr8J9lGmdGY6gjVLPMI+ICTQqwa1PtWEYB9jP5ZKHWizZZHQE89/geNN9jBGDVuegAAAABJRU5ErkJggg==">--}}
</div>
</body>
</html>