//
//  TheNavigationBar.m
//  HopingForAWish
//
//  Created by Austin Chan on 12/2/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "TheNavigationBar.h"
#import <QuartzCore/QuartzCore.h>

@implementation TheNavigationBar

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    
    if (self) {
        UIImageView *aTabBarBackground = [[UIImageView alloc]initWithImage:[UIImage imageNamed:@"greenLinen.png"]];
        aTabBarBackground.frame = CGRectMake(0,0,self.frame.size.width,self.frame.size.height);
        [self addSubview:aTabBarBackground];
        [self sendSubviewToBack:aTabBarBackground];
    }
    return self;
}


// Only override drawRect: if you perform custom drawing.
// An empty implementation adversely affects performance during animation.
- (void)drawRect:(CGRect)rect {

//        UIImage *image = [UIImage imageNamed: @"greenLinen.png"];
//        [image drawInRect:CGRectMake(0, 0, self.frame.size.width, self.frame.size.height)];
    [[UIColor colorWithPatternImage:[UIImage imageNamed:@"redoneGreen.png"]] set];
    CGContextFillRect(UIGraphicsGetCurrentContext(), CGRectMake(0, 0, self.frame.size.width, self.frame.size.height));

        [[UIColor colorWithRed:45/255.0 green:54/255.0 blue:66/255.0 alpha:1] set];
        CGContextFillRect(UIGraphicsGetCurrentContext(), CGRectMake(0, rect.size.height-1, rect.size.width, 1));
        [[UIColor colorWithRed:105/255.0 green:113/255.0 blue:123/255.0 alpha:1] set];
        CGContextFillRect(UIGraphicsGetCurrentContext(), CGRectMake(0, 0, rect.size.width, 1));
        [[UIColor colorWithRed:58/255.0 green:73/255.0 blue:93/255.0 alpha:1] set];
        CGContextFillRect(UIGraphicsGetCurrentContext(), CGRectMake(0, rect.size.height-2, rect.size.width, 1));
        return;
    [super drawRect:rect];

}


@end
