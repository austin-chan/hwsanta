//
//  HomeViewController.h
//  HopingForAWish
//
//  Created by Austin Chan on 12/3/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface HomeViewController : UIViewController <NSURLConnectionDelegate>
@property (weak, nonatomic) IBOutlet UILabel *recipientLabel;
@property (weak, nonatomic) IBOutlet UILabel *santaLabel;
@property (weak, nonatomic) IBOutlet UILabel *nameLabel;
@property (weak, nonatomic) IBOutlet UILabel *countdownLabel;

@end
